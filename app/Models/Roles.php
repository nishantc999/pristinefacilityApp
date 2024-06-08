<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'permission' => 'array'
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id');
       
    }
    public function childRole()
    {
        return $this->belongsTo(Roles::class, 'child_role_id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
