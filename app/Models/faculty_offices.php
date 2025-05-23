<?php

namespace App\Models;
use App\Models\Department;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faculty_offices extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_facultyOffice'; // Custom primary key if needed

    protected $fillable = [
        'name',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}

