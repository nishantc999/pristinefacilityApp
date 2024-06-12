<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
class Client extends Model
{
    use HasApiTokens, Notifiable;
    protected $fillable = [
        'name', 'email', 'password','username',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'lines' => 'array',
    ];
    public function detail()
    {
        return $this->hasOne(ClientDetail::class);
    }
    public function userAssignments()
    {
        return $this->hasMany(UserAssignment::class);
    }

    public function projectManager()
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }
    // unused
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'site_shift_area')
                    ->withPivot('site_id', 'shift_id', 'area_id');
    }

}
