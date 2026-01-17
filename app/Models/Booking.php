<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'car_id',
        'pickup_city',
        'dropoff_city',
        'start_datetime',
        'end_datetime',
        'status',
        'total_price',
        'name',
        'email',
        'phone',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }

    public static function autoCompleteExpiredBookings()
    {
        return self::where('status', '!=', 'completed')
            ->where('end_datetime', '<', Carbon::now())
            ->update(['status' => 'completed']);
    }


}
