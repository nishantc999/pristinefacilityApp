<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inward extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_no',
        'vendor',
        'date', 
        'sku_label_and_quantity',
        'pdf',
        'req',
    ];

    protected $casts = [
      
        'sku_label_and_quantity' => 'array',
    ];
}
