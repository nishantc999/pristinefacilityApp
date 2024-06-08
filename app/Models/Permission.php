<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $fillable = [
        'module_name',
        'feature_name',
        'table',
      ];
      protected $casts = [
        'table' => 'array'
    ];
 
}
