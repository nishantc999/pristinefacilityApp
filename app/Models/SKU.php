<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKU extends Model
{
    use HasFactory;
    protected $fillable = [
        'sku', 'label', 'price', 'unit', 'cities','stock','image','packet_size','max_sale_bundle','is_delete'
    ];

    protected $casts = [
        'stock' => 'array',

    ];
}
