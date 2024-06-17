<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDispatchMeasure extends Model
{
    use HasFactory;
    protected $fillable = [
        'receiver_id',
        'sku_label',
        'sku_quantity', 
        'image',
        'label',
    ];
}
