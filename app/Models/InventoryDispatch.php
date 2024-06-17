<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDispatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'dispatchNumber',
        'sender', 
        'receiver_id', 
        'sendingDate', 
        'receivingDate', 
        'status',
        'product_quantity',
        'req',
        'client_id',
        'shift_id',
    ];

    protected $casts = [
      
        'product_quantity' => 'array',
    ];
}
