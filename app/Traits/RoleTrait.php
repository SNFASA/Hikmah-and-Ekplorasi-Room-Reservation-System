<?php

namespace App\Traits;

trait RoleTrait
{
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function canAccessStudentRoutes()
    {
        return $this->isAdmin() || $this->isStudent() || $this->isStaff();
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
