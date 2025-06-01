<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class list_student_booking extends Model
{
    use HasFactory;

    protected $table = 'list_student_booking';
    protected $primaryKey = 'id';
    protected $fillable = [
        'no_matriks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'no_matriks', 'no_matriks');
    }

    public function bookings()
    {
        return $this->belongsToMany(bookings::class, 'booking_user', 'list_student_booking_id', 'booking_id');
    }
}

