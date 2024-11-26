<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_room';

    protected $fillable = [
        'name',
        'capacity',
        'status',
        'furniture',
        'electronicEquipment',
    ];

    // Relationship to 
    public function furniture()
    {
       return $this->hasMany(furniture::class, 'furniture', 'no_furniture');
    }
    public function electronicEquipment()
    {
       return $this->hasMany(electronic::class, 'electronicEquipment', 'no_electronic');
    }
    public static function countActiveroom(){
        $data=electronic::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}

