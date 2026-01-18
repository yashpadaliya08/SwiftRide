<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $booking = Booking::where('id', $request->booking_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if user already reviewed this car for this booking
        $exists = Review::where('user_id', Auth::id())
            ->where('car_id', $booking->car_id)
            ->where('created_at', '>=', $booking->created_at)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You have already reviewed this trip.');
        }

        Review::create([
            'user_id' => Auth::id(),
            'car_id' => $booking->car_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => false // Wait for admin
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted for moderation.');
    }
}
