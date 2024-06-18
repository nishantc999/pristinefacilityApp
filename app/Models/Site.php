<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;
    public function checklists()
    {
        // return $this->hasMany(Checklist::class);
        return $this->belongsToMany(Checklist::class, 'site_shift_area')->withPivot('client_id','site_id', 'shift_id','area_id')->withTimestamps();
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'site_shift_area')->withPivot('client_id', 'area_id')->withTimestamps();
    }

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'site_shift_area')->withPivot('client_id','site_id', 'shift_id','area_id')->withTimestamps();
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
