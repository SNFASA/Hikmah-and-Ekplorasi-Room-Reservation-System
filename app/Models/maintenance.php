<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class maintenance extends Model
{
  use HasFactory;
    protected $table = 'maintenance';
    protected $fillable = ['title', 'description', 'itemType', 'item_id', 'item_text', 'room_id', 'date_maintenance', 'status','reported_by'];
    protected $primaryKey = 'id';
    protected $casts = [
      'item_id' => 'integer',
      'room_id' => 'integer',
  ];
    // Accessor for itemType
    public function getItemTypeAttribute($value)
    {
        return ucfirst($value);
    }
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
    

    public static function countActiveMaintenance(){
      $data=maintenance::where('status','pending')->count();
      if($data){
          return $data;
      }
      return 0;
  }
}
