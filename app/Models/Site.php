<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;
    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }
    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'site_shift_area')->withPivot('client_id', 'area_id')->withTimestamps();
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'site_shift_area')->withPivot('client_id', 'shift_id')->withTimestamps();
    }
    public function siteShifts()
    {
        return $this->belongsToMany(Shift::class, 'site_shift_area')->withPivot('client_id','site_id', 'shift_id');
       
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function userAssignments()
    {
        return $this->hasMany(UserAssignment::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_assignments')
                    ->withPivot('site_id', 'shift_id', 'user_id','client_id');
    }
}
