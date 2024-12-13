<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule extends Model
{
    use HasFactory;
    protected $table = 'schedule_booking';
    protected $fillable = ['invalid_date', 'invalid_time_start', 'invalid_time_end', 'roomid'];
}
