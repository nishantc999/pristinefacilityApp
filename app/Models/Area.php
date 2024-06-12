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

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function shifts()
    {
        return $this->belongsToMany(Shift::class, 'shift_site_area');
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class, 'shift_site_area');
    }
}
