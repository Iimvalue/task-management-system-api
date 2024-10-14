<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'description', 'status', 'notes', 'assigned_to', 'created_by'];

    // User relations with created by manager or admin
    public function createdTasks()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // User relations with created by manager or admin
    public function assignedTasks()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // User relations with task id
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Define the relationship with the User model
    public function assignedEmployee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
