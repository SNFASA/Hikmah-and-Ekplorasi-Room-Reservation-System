<?php

namespace App\Traits;

trait RoleTrait
{
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isUser(){
        return $this->role === 'user';
    }
    public function isPpp()
    {
        return $this->role === 'ppp';
    }

    public function canAccessUserRoutes()
    {
        return $this->isAdmin() || $this->isUser() || $this->isPpp();
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }
}
