<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Car;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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

        $adjustedStart = $start->copy()->subHours($this->bufferHours);
        $adjustedEnd = $end->copy()->addHours($this->bufferHours);

        $availableCars = Car::all()->filter(function ($car) use ($adjustedStart, $adjustedEnd) {
            return !Booking::where('car_id', $car->id)
                ->where(function ($query) use ($adjustedStart, $adjustedEnd) {
                    $query->whereBetween('start_datetime', [$adjustedStart, $adjustedEnd])
                        ->orWhereBetween('end_datetime', [$adjustedStart, $adjustedEnd])
                        ->orWhere(function ($q) use ($adjustedStart, $adjustedEnd) {
                            $q->where('start_datetime', '<', $adjustedStart)
                                ->where('end_datetime', '>', $adjustedEnd);
                        });
                })
                ->exists();
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

        $adjustedStart = $start->copy()->subHours($this->bufferHours);
        $adjustedEnd = $end->copy()->addHours($this->bufferHours);

        $conflict = Booking::where('car_id', $request->car_id)
            ->where(function ($query) use ($adjustedStart, $adjustedEnd) {
                $query->whereBetween('start_datetime', [$adjustedStart, $adjustedEnd])
                    ->orWhereBetween('end_datetime', [$adjustedStart, $adjustedEnd])
                    ->orWhere(function ($q) use ($adjustedStart, $adjustedEnd) {
                        $q->where('start_datetime', '<', $adjustedStart)
                            ->where('end_datetime', '>', $adjustedEnd);
                    });
            })->exists();

        if ($conflict) {
            return redirect()->route('booking.selectCriteria')
                ->withErrors(['conflict' => 'Selected car is not available at that time.'])->withInput();
        }

        Booking::create([
            'user_id' => Auth::id(),
            'car_id' => $request->car_id,
            'pickup_city' => $request->pickup_city,
            'dropoff_city' => $request->dropoff_city,
            'start_datetime' => $start,
            'end_datetime' => $end,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('booking.myBookings')->with('success', 'Booking confirmed successfully!');
    }

    public function myBookings()
    {
        $bookings = Booking::with('car')
            ->where('user_id', Auth::id())
            ->latest('start_datetime')
            ->paginate(10);

        return view('client.my_bookings', compact('bookings'));
    }
}
