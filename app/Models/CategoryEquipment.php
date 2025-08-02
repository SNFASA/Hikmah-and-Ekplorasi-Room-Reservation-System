<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryEquipment extends Model
{
    use HasFactory;
    protected $table = 'categories_equipment';

    protected $fillable = ['name'];

    // Optional: define relationship to electronics
    public function electronics()
    {
        return $this->hasMany(Electronic::class, 'category_id');
    }

    // Optional: define relationship to furniture
    public function furniture()
    {
        return $this->hasMany(Furniture::class, 'category_id');
    }
}
