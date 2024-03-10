<?php

namespace App\Repositories;

use App\Models\BoutiquesModel;
use App\Models\ProductsModel;

class BoutiquesRepository {
    private $boutiquesModel;

    public function __construct(BoutiquesModel $boutiquesModel){
        $this->boutiquesModel = $boutiquesModel;
    }

    public function getAllBoutiques(){
        try{
            $allBoutiques = BoutiquesModel::all();
            $featuredProducts = ProductsModel::with(['boutique','subcategory'])->where('featured',true)->get();
            return([
                'allBoutiques'=>$allBoutiques,
                'featuredProducts'=>$featuredProducts
            ]);

        }catch(\Exception $e){
            dd($e->getMessage());
        }
    }


    public function getThisBoutique($boutiqueName){
        $name = str_replace('-',' ',$boutiqueName);
        try{
            $boutique = BoutiquesModel::with('product')->where('name',$name)->first();

            if (!$boutique) {
                return response()->json(['message' => 'Boutique not found'], 404);
            }else{
                return ($boutique);

            }

        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving boutique details'], 500);

        }
    }
}
