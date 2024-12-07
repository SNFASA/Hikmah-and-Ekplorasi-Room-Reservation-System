<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_room';
    protected$no_room;
    protected $name;
    protected $capacity;
    protected $status;

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
    
    // Count active rooms
    public static function countActiveRoom()
    {
        $data = self::where('status', 'valid')->count();
        return $data ?: 0;
    }
}
