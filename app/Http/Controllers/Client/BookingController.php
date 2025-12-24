<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Revenue;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\BookingConfirmationMail;
use App\Mail\AdminBookingNotificationMail;

class BookingController extends Controller
{
    protected array $cities = ['Rajkot', 'Ahmedabad', 'Vadodara', 'Surat', 'Jamnagar'];
    protected int $bufferHours = 8; // Admin-defined buffer

    public function selectCriteria()
    {
        return view('client.booking.select_criteria', ['cities' => $this->cities]);
    }

    // POST: /booking/search
    public function handleSearch(Request $request)
    {
        $validated = $request->validate([
            'pickup_city' => 'required|string|in:' . implode(',', $this->cities),
            'dropoff_city' => 'required|string|in:' . implode(',', $this->cities),
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
        ]);

        return redirect()->route('booking.available', $validated);
    }

    // GET: /booking/available
    public function showAvailableCars(Request $request)
    {
        $pickup_city = $request->query('pickup_city');
        $dropoff_city = $request->query('dropoff_city');
        $start_date = $request->query('start_date');
        $start_time = $request->query('start_time');
        $end_date = $request->query('end_date');
        $end_time = $request->query('end_time');

        if (!$pickup_city || !$dropoff_city || !$start_date || !$start_time || !$end_date || !$end_time) {
            return redirect()->route('booking.selectCriteria')
                ->withErrors(['missing' => 'Please submit the form to view available cars.']);
        }

        $start = Carbon::parse("{$start_date} {$start_time}");
        $end = Carbon::parse("{$end_date} {$end_time}");

        if ($end->lessThanOrEqualTo($start)) {
            return redirect()->route('booking.selectCriteria')
                ->withErrors(['end_time' => 'End time must be after start time'])->withInput();
        }

        $availableCars = Car::all()->filter(function ($car) use ($start, $end) {
            return !$this->hasConflict($car->id, $start, $end);
        });

        return view('client.booking.available_cars', [
            'availableCars' => $availableCars,
            'pickup_city' => $pickup_city,
            'dropoff_city' => $dropoff_city,
            'start_date' => $start_date,
            'start_time' => $start_time,
            'end_date' => $end_date,
            'end_time' => $end_time,
        ]);
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'pickup_city' => 'required|string|in:' . implode(',', $this->cities),
            'dropoff_city' => 'required|string|in:' . implode(',', $this->cities),
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
        ]);

        $start = Carbon::parse("{$request->start_date} {$request->start_time}");
        $end = Carbon::parse("{$request->end_date} {$request->end_time}");
        $car = Car::findOrFail($request->car_id);
        $days = $start->diffInDays($end) + 1;
        $total = $days * $car->price_per_day;

        return view('client.booking.confirm_booking', [
            'car' => $car,
            'start' => $start,
            'end' => $end,
            'total' => $total,
            'pickup_city' => $request->pickup_city,
            'dropoff_city' => $request->dropoff_city,
            'start_date' => $request->start_date,
            'start_time' => $request->start_time,
            'end_date' => $request->end_date,
            'end_time' => $request->end_time,
        ]);
    }

    public function storeConfirmed(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'pickup_city' => 'required|string|in:' . implode(',', $this->cities),
            'dropoff_city' => 'required|string|in:' . implode(',', $this->cities),
            'start_date' => 'required|date',
            'start_time' => 'required',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required',
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
        ]);

        $start = Carbon::parse("{$request->start_date} {$request->start_time}");
        $end = Carbon::parse("{$request->end_date} {$request->end_time}");

        if ($this->hasConflict($request->car_id, $start, $end)) {
            return redirect()->route('booking.selectCriteria')
                ->withErrors(['conflict' => 'Selected car is not available at that time.'])->withInput();
        }

        $car = Car::findOrFail($request->car_id);
        $days = $start->diffInDays($end) + 1;
        $total = $days * $car->price_per_day;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'car_id' => $car->id,
            'pickup_city' => $request->pickup_city,
            'dropoff_city' => $request->dropoff_city,
            'start_datetime' => $start,
            'end_datetime' => $end,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'total_price' => $total,
        ]);

        // Load relationships for email
        $booking->load(['car', 'user']);

        // Send email to customer
        try {
            Mail::to($request->email)->send(new BookingConfirmationMail($booking));
        } catch (\Exception $e) {
            // Log error but don't break the flow
            \Log::error('Failed to send customer booking email: ' . $e->getMessage());
        }

        // Send email to admin
        $adminEmail = config('swiftride.admin_email', 'swiftride15@gmail.com');
        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(new AdminBookingNotificationMail($booking));
            } catch (\Exception $e) {
                // Log error but don't break the flow
                \Log::error('Failed to send admin booking email: ' . $e->getMessage());
            }
        }

        return redirect()->route('booking.myBookings')->with('success', 'Booking confirmed successfully! You will receive a confirmation email shortly.');
    }

    public function myBookings()
    {
        $bookings = Booking::with('car')
            ->where('user_id', Auth::id())
            ->latest('start_datetime')
            ->paginate(10);

        return view('client.my_bookings', compact('bookings'));
    }

    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking already cancelled.');
        }

        // 1. Update booking status
        $booking->status = 'cancelled';
        $booking->save();

        // 2. Create refund revenue
        Revenue::create([
            'booking_id' => $booking->id,
            'amount' => -$booking->total_price,
            'type' => Revenue::TYPE_REFUND,
            'status' => Revenue::STATUS_REFUNDED,
        ]);

        return back()->with('success', 'Booking cancelled and refund recorded.');
    }

public function myBookingsData(Request $request)
{
    $bookings = Booking::with('car')
        ->where('user_id', Auth::id())
        ->latest('start_datetime');

    return DataTables::of($bookings)
        ->addColumn('car', function ($b) {
            return $b->car?->brand . ' ' . $b->car?->model ?? 'N/A';
        })
        ->addColumn('from', function ($b) {
            return $b->start_datetime->format('d M, Y H:i');
        })
        ->addColumn('to', function ($b) {
            return $b->end_datetime->format('d M, Y H:i');
        })
        ->addColumn('status_badge', function ($booking) {
            // Dynamically override 'status' if currently active
            $now = now();

            if (
                $booking->status === 'confirmed' &&
                $booking->start_datetime <= $now &&
                $booking->end_datetime >= $now
            ) {
                $booking->status = 'active';
            }

            return view('client.components.status_badge', ['booking' => $booking]);
        })
        ->addColumn('action', function ($b) {
            return view('client.components.cancel_button', ['booking' => $b]);
        })
        ->rawColumns(['status_badge', 'action'])
        ->make(true);
}

    // Reusable method to check booking conflicts considering buffer and canceled bookings
    private function hasConflict(int $carId, Carbon $start, Carbon $end): bool
    {
        $adjustedStart = $start->copy()->subHours($this->bufferHours);
        $adjustedEnd = $end->copy()->addHours($this->bufferHours);

        return Booking::where('car_id', $carId)
            ->where('status', '!=', 'cancelled')
            ->where('end_datetime', '>=', $adjustedStart)
            ->where(function ($query) use ($adjustedStart, $adjustedEnd) {
                $query->whereBetween('start_datetime', [$adjustedStart, $adjustedEnd])
                    ->orWhereBetween('end_datetime', [$adjustedStart, $adjustedEnd])
                    ->orWhere(function ($q) use ($adjustedStart, $adjustedEnd) {
                        $q->where('start_datetime', '<', $adjustedStart)
                            ->where('end_datetime', '>', $adjustedEnd);
                    });
            })
            ->exists();
    }
}
