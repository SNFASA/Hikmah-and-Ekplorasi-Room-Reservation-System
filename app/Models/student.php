<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_matriks',
        'name',
        'facultyOffice',
        'course',
        'email',
        'password',
        'receive_notifications',
    ];
}
