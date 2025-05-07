<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';
    protected $fillable = [
        'booking_id',
        'user_id',
        'rating',
        'comment',
        'category',
    ];
    public function booking()
    {
        return $this->belongsTo(bookings::class, 'booking_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(list_student_booking::class, 'user_id', 'id');
    }
}
