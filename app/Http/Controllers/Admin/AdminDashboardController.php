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
        $users = User::latest()->get();
        return view('admin.users', compact('users'));
    }
    public function dashboard()
    {
        // 1. Key Counters
        $userCount = User::count();
        $bookingCount = Booking::count();
        $carCount = Car::count();
        $totalRevenue = Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $verifiedUserCount = User::where('is_verified', true)->count();

        // 2. Recent Bookings (Table)
        $recentBookings = Booking::with(['user', 'car'])
            ->latest()
            ->take(5)
            ->get();

        // 3. Monthly Revenue Chart Data (Last 6 Months)
        $revenueData = [];
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $months[] = $monthName;
            
            // Sum confirmed/completed bookings for this month
            // Note: In SQLite, month grouping can be tricky, so we use whereBetween for compatibility
            $monthlySum = Booking::whereIn('status', ['confirmed', 'completed'])
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_price');
                
            $revenueData[] = $monthlySum;
        }

        // 4. Car Popularity (Pie Chart)
        // Group bookings by car type
        $popularCars = Booking::join('cars', 'bookings.car_id', '=', 'cars.id')
            ->selectRaw('cars.type, count(*) as count')
            ->groupBy('cars.type')
            ->pluck('count', 'type')
            ->all();

        // Ensure we have labels and data even if empty
        $carTypes = array_keys($popularCars);
        $carTypeCounts = array_values($popularCars);

        return view('admin.dashboard', compact(
            'userCount', 
            'bookingCount', 
            'carCount', 
            'totalRevenue', 
            'recentBookings',
            'months',
            'revenueData',
            'carTypes',
            'carTypeCounts',
            'verifiedUserCount'
        ));
    }

    public function calendar()
    {
        $bookings = Booking::with('car')->get()->map(function ($booking) {
            $color = match($booking->status) {
                'confirmed' => '#198754', // Green
                'pending' => '#ffc107',   // Yellow
                'completed' => '#0d6efd', // Blue
                'cancelled' => '#dc3545', // Red
                default => '#6c757d'
            };

            return [
                'title' => ($booking->car->brand ?? 'Car') . ' ' . ($booking->car->model ?? '') . ' (' . $booking->user->name . ')',
                'start' => $booking->start_datetime->toIso8601String(),
                'end' => $booking->end_datetime->toIso8601String(),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'url' => route('admin.bookings.show', $booking->id)
            ];
        });

        return view('admin.calendar', compact('bookings'));
    }

}
