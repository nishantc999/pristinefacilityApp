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
    public function sites() {
        return $this->belongsToMany(Site::class, 'site_shift');
    }
    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }
}
