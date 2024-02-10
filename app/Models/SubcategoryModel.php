<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcategoryModel extends Model
{

    protected $table = 'subcategory';
    protected $fillable = [
        'name',
        'category_id',
    ];
    use HasFactory;

    public function withSubCategory(){
        return $this->belongsTo(CategoryModel::class,'id','category_id');
    }
}
