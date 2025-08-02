<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeRooms extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
        public function rooms()
    {
        return $this->hasMany(room::class, 'type_room');
    }

}
