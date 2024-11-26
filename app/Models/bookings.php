<?php

namespace App\Models;
use App\Models\room;
use App\Models\list_student_booking;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookings extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Custom primary key if needed

    protected $fillable = [
        'booking_date',
        'booking_time',
        'purpose',
        'no_room',        
        'phone_number',        
        'status',        
        'list_student',
    ];

    public function room()
    {
        return $this->belongsTo(room::class, 'no_room');
    }

    public function listStudentBooking()
    {
        return $this->belongsTo(list_student_booking::class, 'list_student');
    }
    public static function countActiveBooking(){
        $data=bookings::where('status','approved')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
