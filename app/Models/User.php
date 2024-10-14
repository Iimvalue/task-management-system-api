<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin()
    {
        return $this->role === 'Admin';
    }


    public function isManager()
    {
        return $this->role === 'Manager';
    }


    public function isEmployee()
    {
        return $this->role === 'Employee';
    }
    // tasks relations with created by manager or admin
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    // tasks relations with assigned to user by manager or admin 
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    // notification relations with user id
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
