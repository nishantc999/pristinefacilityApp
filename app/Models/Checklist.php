<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'area_id',
        'shift_id',
        'site_id',
        'variables',
        'client_id',
        'status',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
    public function getVariablesAttribute($value)
    {
        return Variables::whereIn('id', json_decode($value))->get();
    }
}
