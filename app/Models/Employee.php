<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'family_detail' => 'array',
        'documents' => 'array'
    ];

    // public function site()
    // {
    //     return $this->belongsTo(Site::class);
    // }

    // public function area()
    // {
    //     return $this->belongsTo(Area::class);
    // }

    // public function shift()
    // {
    //     return $this->belongsTo(Shift::class);
    // }

    // public function client()
    // {
    //     return $this->belongsTo(Client::class);
    // }
    public function employeeDetail()
    {
        return $this->hasOne(EmployeeDetail::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class, 'client_employee_shift_site')
                    ->withPivot('shift_id', 'site_id')
                    ->withTimestamps();
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'client_employee_shift_site')
                    ->withPivot('client_id', 'site_id')
                    ->withTimestamps();
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'client_employee_shift_site')
                    
                    ->withTimestamps();
    }
    public function attendances()
    {
        return $this->hasMany(EmployeeAttendance::class);
    }
    public function complaints()
    {
        return $this->hasMany(ComplaintTicket::class);
    }
}
