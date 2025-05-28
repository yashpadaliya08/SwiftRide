<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Message;
use App\Models\Car;
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
        // $messageCount = Message::count();
        $carCount = Car::count();

       return view('admin.dashboard', compact('userCount', 'bookingCount',  'carCount'));
    }

}
