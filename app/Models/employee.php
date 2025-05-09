<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'name',
        'age',
        'gender',
        'position',
        'password',
        'salary',
        'contactno',
        'type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Automatically hash password when setting it.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // ✅ Relationship for attendance records
    public function attendances()
    {
        return $this->hasMany(\App\Models\Attendance::class, 'employee_id');
    }
}
