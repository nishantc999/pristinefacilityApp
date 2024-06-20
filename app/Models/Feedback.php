<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    public function variable()
    {
        return $this->belongsTo(Variables::class, 'checklist_variable_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'rating_given_by');
    }
}
