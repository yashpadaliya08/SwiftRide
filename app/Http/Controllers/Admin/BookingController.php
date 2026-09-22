<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Revenue;

use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('car', 'user')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with('car', 'user')->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function confirmBooking($id)
    {
        $booking = Booking::with('user', 'car')->findOrFail($id);

        if ($booking->status !== 'confirmed') {
            $booking->status = 'confirmed';
            $booking->save();

            // Create a revenue record
            Revenue::create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price,
                'type' => Revenue::TYPE_PAYMENT,
                'status' => Revenue::STATUS_RECEIVED,
            ]);

            // Award Loyalty Points if associated user exists
            if ($booking->user) {
                $user = $booking->user;
                $earnedPoints = floor($booking->total_price / 100);
                $user->loyalty_points += $earnedPoints;

                if ($user->loyalty_points >= 15000) {
                    $user->membership_tier = 'Platinum';
                } elseif ($user->loyalty_points >= 5000) {
                    $user->membership_tier = 'Gold';
                }
                $user->save();
            }

            // Send confirmation email to customer
            try {
                Mail::to($booking->email)->send(new BookingConfirmationMail($booking));
            } catch (\Exception $e) {
                \Log::error('Failed to send customer confirmation email from admin: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.bookings.show', $booking->id)->with('success', 'Booking confirmed, revenue recorded, and customer notified.');
    }

    public function cancelBooking($id)
    {
        $booking = Booking::with('user')->findOrFail($id);

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking is already cancelled.');
        }

        if ($booking->status === 'completed') {
            return back()->with('error', 'Completed bookings cannot be cancelled.');
        }

        $wasConfirmed = ($booking->status === 'confirmed');

        $booking->status = 'cancelled';
        $booking->save();

        if ($wasConfirmed) {
            Revenue::create([
                'booking_id' => $booking->id,
                'amount' => -$booking->total_price,
                'type' => Revenue::TYPE_REFUND,
                'status' => Revenue::STATUS_REFUNDED,
            ]);

            if ($booking->user) {
                $user = $booking->user;
                $pointsToDeduct = floor($booking->total_price / 100);
                $user->loyalty_points = max(0, $user->loyalty_points - $pointsToDeduct);
                if ($user->loyalty_points < 5000) {
                    $user->membership_tier = 'Standard';
                } elseif ($user->loyalty_points < 15000) {
                    $user->membership_tier = 'Gold';
                }
                $user->save();
            }
        }

        return redirect()->route('admin.bookings.show', $booking->id)->with('success', 'Booking cancelled successfully.');
    }
}
