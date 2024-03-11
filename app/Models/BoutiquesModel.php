<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoutiquesModel extends Model
{
    protected $table="boutiques";
    protected $fillable = [
        'name',
        'address',
        'email',
        'phone',
        'image',
        'image2',
        'image3',
        'view',
        'description'
    ];
    use HasFactory;

    public function product(){
        return $this->hasMany(ProductsModel::class,'boutique_id','id');
    }


}
