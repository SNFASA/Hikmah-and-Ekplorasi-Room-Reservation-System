<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Room;
use App\Models\list_student_booking;
use Carbon\Carbon;

class bookings extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_date',
        'booking_time_start',
        'booking_time_end',
        'duration',
        'purpose',
        'no_room',
        'phone_number',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'no_room', 'name');
    }

    public function listStudentBookings()
    {
        return $this->belongsToMany(list_student_booking::class, 'booking_user', 'booking_id', 'list_student_booking_id', 'id');
    }

    public static function countActiveBooking()
    {
        return self::where('status', 'approved')->count();
    }

    public function calculateDuration()
    {
        if ($this->booking_time_start && $this->booking_time_end) {
            return Carbon::parse($this->booking_time_start)->diffInMinutes($this->booking_time_end);
        }
        return null;
    }
}
