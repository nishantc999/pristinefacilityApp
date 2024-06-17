<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintTicket extends Model
{
    use HasFactory;
    protected $guarded = [];




    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function complainer()
    {
        return $this->belongsTo(Client::class, 'complainer_id');
    }

    public function closer()
    {
        return $this->belongsTo(User::class, 'closer_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
    public function replies()
    {
        return $this->hasMany(ComplaintReply::class);
    }
}
