<?php

namespace App\Models;
use App\Models\Courses;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_department';

    protected $fillable = [
        'name',
    ];
    public function courses()
    {
        return $this->hasMany(Courses::class, 'department_id', 'no_department');
    }
}
