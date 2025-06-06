<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Car;
use App\Models\Revenue;
class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }
    public function registeredUsers()
    {
        $users = \App\Models\User::all();
        return view('admin.users', compact('users'));
    }
    public function dashboard()
    {
        $userCount = User::count();
        $bookingCount = Booking::count();
        $carCount = Car::count();

        // Recommended: use bookings for revenue
        $totalRevenue = Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');

        $recentBookings = Booking::with(['user', 'car'])
        ->latest()
        ->take(5)
        ->get();

        return view('admin.dashboard', compact('userCount', 'bookingCount', 'carCount', 'totalRevenue' ,'recentBookings'));
    }

}
