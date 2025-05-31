<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
// use App\Models\Driver;

class AdminReportController extends Controller
{
  public function reports()
  {

    Booking::autoCompleteExpiredBookings();

    // Total registered users
    $totalUsers = User::count();

    // Total completed rides/bookings
    $totalRides = Booking::where('status', 'completed')->count();

    // Total revenue from completed bookings
    $totalRevenue = Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');



    // Active drivers (assuming 'drivers' table or users with role=driver & active)
    //  $activeDrivers = Driver::where('status', 'active')->count(); 
    // Or: User::where('role', 'driver')->where('status', 'active')->count();

    // Recent rides
    $recentRides = Booking::with(['user']) // eager load relations
      ->latest()
      ->take(5)
      ->get();

    return view('admin.reports', compact('totalUsers', 'totalRides', 'totalRevenue', 'recentRides'));
  }
}
