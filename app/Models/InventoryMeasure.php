<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryMeasure extends Model
{
    use HasFactory;
    protected $fillable = [
        'sku_label',
        'sku_quantity', 
        'image',
        'label',
    ];
}
