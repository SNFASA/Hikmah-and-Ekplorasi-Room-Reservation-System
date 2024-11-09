<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class booking extends Model
{
    protected $fillable = ['booking_date', 'booking_time', 'purpose', 'room_id', 'phone_number', 'status'];

    // In Booking.php
    public function users()
    {
        return $this->belongsToMany(User::class, 'booking_user', 'booking_id', 'user_no_matriks');
    }

}
