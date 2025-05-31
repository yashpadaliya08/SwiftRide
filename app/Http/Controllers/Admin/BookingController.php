<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Revenue;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('car', 'user')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with('car')->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }
    public function confirmBooking($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'confirmed') {
            $booking->status = 'confirmed';
            $booking->save();

            // Create a revenue record
            Revenue::create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price,
                'type' => 'payment',
                'status' => 'received',
            ]);
        }

        return redirect()->route('admin.bookings.show', $booking->id)->with('success', 'Booking confirmed and revenue recorded.');
    }

}
