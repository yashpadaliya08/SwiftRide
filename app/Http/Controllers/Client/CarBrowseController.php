<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarBrowseController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::where('status', 'available');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%");
            });
        }

        if ($request->filled('max_price')) {
            $query->where('price_per_day', '<=', $request->max_price);
        }

        if ($request->filled('transmission') && strtolower($request->transmission) !== 'all') {
            $query->whereRaw('LOWER(transmission) = ?', [strtolower($request->transmission)]);
        }

        if ($request->filled('type') && strtolower($request->type) !== 'all') {
            $query->whereRaw('LOWER(type) = ?', [strtolower($request->type)]);
        }

        $cars = $query->latest()->get();

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