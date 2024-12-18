<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_room';
    protected $fillable = ['no_room', 'name', 'capacity', 'status', 'type_room'];

    public $incrementing = true;     // set no_room is  auto-incrementing
    protected $keyType = 'string';    // Use 'string' if no_room is a string type, otherwise 'int'

    public function furnitures()
    {
        return $this->belongsToMany(furniture::class, 'furniture_room', 'room_id', 'furniture_id', 'no_room', 'no_furniture');
    }
    
    public function electronics()
    {
        return $this->belongsToMany(electronic::class, 'electronic_equipment_room', 'room_id', 'electronic_equipment_id', 'no_room', 'no_electronicEquipment');
    }
    public function schedule()
    {
        return $this->belongsToMany(schedule::class, 'schedule_booking', 'roomid', 'invalid_date', 'invalid_time_start', 'invalid_time_end');
    }
    
    // Count active rooms
    public static function countActiveRoom()
    {
        $data = self::where('status', 'valid')->count();
        return $data ?: 0;
    }
    public static function getRoomType()
    {
    return self::select('type_room')->distinct()->get();
    }
}
