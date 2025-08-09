<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class electronic extends Model
{
    use HasFactory;
    protected $table = 'electronic_equipment'; // Custom table name if needed
    protected $primaryKey = 'no_electronicEquipment'; // Custom primary key if needed

    protected $fillable = [
        'name',
        'category_id',
        'status',
    ];
    public static function countActiveElectronic(){
        $data=electronic::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
    public function rooms()
    {
        return $this->belongsToMany(room::class, 'electronic_equipment_room', 'electronic_equipment_id', 'room_id', 'no_electronicEquipment', 'no_room');
    }
    public static function getElectronicCategories()
    {
    return self::select('category_id')->distinct()->get();
    }
    public function category()
    {
        return $this->belongsTo(CategoryEquipment::class, 'category_id');
    }
}
