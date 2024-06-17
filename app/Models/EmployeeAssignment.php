<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAssignment extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'client_employee_shift_site';
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);// kon employee kis user ke under me hai 
    }

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

