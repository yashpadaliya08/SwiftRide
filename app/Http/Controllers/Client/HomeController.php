<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch a few cars to show on the home page
        $cars = Car::latest()->take(4)->get(); // Change the number as needed

        return view('client.home', compact('cars'));
    }
}
