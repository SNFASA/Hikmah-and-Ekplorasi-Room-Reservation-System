<?php

namespace App\Models;

use App\Models\department;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_course';
    protected $fillable = [
        'name',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(department::class, 'department_id', 'no_department');
    }
    public static function getAllCourses()
    {
        return self::all();
    }
    public static function getAlldepartments()
    {
        return department::all();
    }
}
