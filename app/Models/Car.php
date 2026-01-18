<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = [
        'name', 'brand', 'model', 'year', 'color', 'price_per_day', 'description', 
        'image', 'type', 'status', 'transmission', 'fuel_type', 'seats'
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function averageRating()
    {
        return round($this->approvedReviews()->avg('rating'), 1) ?: 0;
    }
}
