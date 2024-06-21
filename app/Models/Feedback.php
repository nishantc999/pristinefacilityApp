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
        return $this->belongsTo(Variables::class);
    }

    public function user()
    {
        return $this->belongsTo(Client::class, 'rating_given_by');
    }
}
