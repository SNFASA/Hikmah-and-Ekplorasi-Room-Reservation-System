<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'no_matriks',
        'name',
        'email',
        'password',
        'role',             // Indicates if the user is a student or staff
        'facultyOffice',    // Used for staff
        'course',           // Used for students
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    use Notifiable;
    public function isAdmin()
    {
        return $this->role === 'staff'; 
    }
    public function isStudent()
    {
        return $this->role === 'student';
    }
    public function canAccessStudentRoutes()
    {
        return $this->isAdmin() || $this->isStudent();
    }
    
}
