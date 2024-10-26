<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_room';

    // Relationship to RoomBooking
    public function bookings()
    {
        return $this->hasMany(RoomBooking::class, 'room_id');
    }
}

