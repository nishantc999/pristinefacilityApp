<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variables extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'checklist_variable_id');
    }
}
