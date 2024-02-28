<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_items';
    protected $fillable = [
        'product_id',
        'order_id',
        'product_name',
        'product_size',
        'quantity',
        'product_color',
        'boutique',
        'product_price',
    ];
    use HasFactory;
}
