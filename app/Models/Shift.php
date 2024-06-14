<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $guarded = [];
    use HasFactory;
    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'days' => 'json',
        'weekday' => 'json',
    ];

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'site_shift_area')->withPivot('client_id', 'area_id')->withTimestamps();
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'site_shift_area')->withPivot('client_id', 'site_id')->withTimestamps();
    }
    public function userAssignments()
    {
        return $this->hasMany(UserAssignment::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_assignments')
                    ->withPivot('site_id', 'shift_id', 'user_id');
    }
    // public function users()
    // {
    //     return $this->belongsToMany(UserAssignment::class);
    // }
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'client_employee_shift_site')
                    
                    ->withTimestamps();
    }
    
}
