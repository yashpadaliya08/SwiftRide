<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
    'name', 'brand', 'model', 'year', 'color', 'price_per_day', 'description', 'image', 'type', 'status', 
    'transmission', 'fuel_type', 'seats'
];

}
