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
    ];
    use HasFactory;

    public function product(){
        return $this->belongsTo(BoutiquesModel::class,'id','boutique_id');
    }
}
