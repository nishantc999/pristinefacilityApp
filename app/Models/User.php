<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
     
    ];
    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
 



    public function relatedUsers()
    {
        return $this->belongsToMany(User::class, 'user_user', 'user_id', 'related_user_id');
    }
    public function userDetail()
    {
        return $this->hasOne(UserDetail::class);
    }
    public function UserAssignment()
    {
        return $this->hasOne(UserAssignment::class);
    }
    public function sites()
    {
        return $this->belongsToMany(Site::class, 'user_assignments')
        ->withPivot('site_id', 'shift_id', 'user_id','client_id')
                    ->withTimestamps();
    }
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'client_employee_shift_site')
                    
                    ->withTimestamps();
    }
}
