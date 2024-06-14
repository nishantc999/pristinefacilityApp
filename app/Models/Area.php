<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'site_shift_area')->withPivot('client_id', 'shift_id')->withTimestamps();
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'site_shift_area')->withPivot('client_id', 'site_id')->withTimestamps();
    }
}
