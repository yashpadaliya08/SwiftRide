<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarBrowseController extends Controller
{
    public function index()
    {
        $cars = Car::where('status', 'available')->latest()->get();
        return view('client.browse', compact('cars'));
    }
    public function show($id)
    {
        $car = Car::with(['approvedReviews.user'])->findOrFail($id);
        return view('client.car-details', compact('car'));
    }

    public function book(Request $request)
    {
        $car = null;
        if ($request->has('car_id')) {
            $car = Car::find($request->car_id);
        }
        return view('client.book', compact('car'));
    }
}