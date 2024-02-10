<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    protected $table='category';
    protected $fillable = [
        'name',

    ];
    use HasFactory;

    public function withSubCategory(){
        return $this->hasMany(SubcategoryModel::class,'category_id','id');
    }
}
