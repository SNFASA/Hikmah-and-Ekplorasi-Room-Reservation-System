<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_matriks';

    // Relationship to BookingParticipant
    public function bookings()
    {
        return $this->morphMany(BookingParticipant::class, 'participant');
    }
}

