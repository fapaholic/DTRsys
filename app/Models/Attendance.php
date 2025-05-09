<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'attendance_id';
    public $incrementing = true;
    protected $fillable = [
        'employee_id',
        'time_in',
        'time_out',
        'date',
        'status',
        'type',
    ];
}

