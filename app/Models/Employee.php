<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'family_detail' => 'array',
        'documents' => 'array'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function employeeDetail()
    {
        return $this->hasMany(EmployeeDetail::class);
    }
}
