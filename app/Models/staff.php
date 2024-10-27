<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_staff',
        'name',
        'facultyOffice',
        'email',
        'password',
        'role',
        'receive_notifications',
    ];
}
