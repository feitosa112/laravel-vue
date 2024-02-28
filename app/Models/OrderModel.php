<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'order';
    protected $fillable = [
        'customer_name',
        'customer_surname',
        'customer_address',
        'customer_phone',
        'total_price'

    ];
    use HasFactory;
}
