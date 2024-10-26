<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 
        'participant_id', 
        'participant_type', 
        'no_matriks_staff', 
        'name', 
        'phone_number', 
        'facultyOffice',
    ];

    // Relationship to RoomBooking (Many-to-One)
    public function booking()
    {
        return $this->belongsTo(RoomBooking::class, 'booking_id');
    }

    // Polymorphic relationship to Student or Staff
    public function participant()
    {
        return $this->morphTo();
    }
}

