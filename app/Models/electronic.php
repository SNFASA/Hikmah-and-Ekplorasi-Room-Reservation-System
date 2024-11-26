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
        'category',
        'status',
    ];
    public static function countActiveElectronic(){
        $data=electronic::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
