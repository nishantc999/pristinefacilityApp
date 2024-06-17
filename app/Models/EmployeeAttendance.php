<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'mark_by',
        'check_in',
        'check_out',
        'attendance_status',
    ];
    protected $casts = [
     
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
