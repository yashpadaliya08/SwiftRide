<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cars = Car::latest()->get(); // get all cars, latest first
        return view('admin.cars.index', compact('cars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cars.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'color' => 'required|string|max:50',
            'price_per_day' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'type' => 'nullable|string|max:50',
            'status' => 'required|in:available,unavailable',
            'transmission' => 'required|in:manual,automatic',
            'fuel_type' => 'required|in:petrol,diesel,electric,hybrid',
            'seats' => 'required|integer|min:1|max:50',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cars', 'public');
        }

        Car::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'color' => $request->color,
            'price_per_day' => $request->price_per_day,
            'description' => $request->description,
            'image' => $imagePath,
            'type' => $request->type,
            'status' => $request->status,
            'transmission' => $request->transmission,
            'fuel_type' => $request->fuel_type,
            'seats' => $request->seats,
        ]);

        return redirect()->route('admin.cars.index')->with('success', 'Car added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $car = Car::findOrFail($id);
        return view('admin.cars.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $car = Car::findOrFail($id);
        return view('admin.cars.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer',
            'color' => 'required|string|max:50',
            'price_per_day' => 'required|numeric',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $car = Car::findOrFail($id);

        $data = $request->only([
            'name',
            'brand',
            'model',
            'year',
            'color',
            'price_per_day',
            'description'
        ]);

        // If new image uploaded, store it
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Car deleted successfully!');
    }
}

