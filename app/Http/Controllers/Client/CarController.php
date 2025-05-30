<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
        public function index()
        {
            $cars = Car::all(); // You can paginate or filter later
            return view('client.cars.index', compact('cars'));
        }
}
