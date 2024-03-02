<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsModel extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'boutique_id',
        'category_id',
        'subcategory_id',
        'boutique_id',
        'cart_quantity',
    ];
    use HasFactory;

    public function boutique(){
        return $this->hasMany(BoutiquesModel::class,'id','boutique_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItemModel::class);
    }

    public function subcategory(){
        return $this->hasMany(SubcategoryModel::class,'id','subcategory_id');
    }
}
