<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDispatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'dispatchNumber',
        'sendor', 
        'receiver', 
        'sendingDate', 
        'receivingDate', 
        'status',
        'product_quantity',
        'req',
        'client',
        'Shift',
    ];

    protected $casts = [
      
        'product_quantity' => 'array',
    ];
}
