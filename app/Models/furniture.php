<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class furniture extends Model
{
    use HasFactory;
    protected $primaryKey = 'no_furniture'; // Custom primary key if needed
    protected $fillable = [
        'name',
        'category',
        'status',
    ];
    public static function countActiveFurniture(){
        $data=furniture::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
    public function rooms()
    {
        return $this->belongsToMany(room::class, 'furniture_room', 'furniture_id', 'room_id', 'no_furniture', 'no_room');
    }
}
