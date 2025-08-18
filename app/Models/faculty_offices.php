<?php

namespace App\Models;
use App\Models\department;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faculty_offices extends Model
{
    use HasFactory;

    protected $primaryKey = 'no_facultyOffice'; // Custom primary key if needed

    protected $fillable = [
        'name',
        
    ];
}

