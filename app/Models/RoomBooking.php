<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id', 
        'room_type', 
        'status', 
        'purpose_of_usage', 
        'date',
    ];

    // Relationship to Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'no_room');
    }

    // Relationship to BookingParticipant (One-to-Many)
    public function participants()
    {
        return $this->hasMany(BookingParticipant::class, 'booking_id');
    }
}

