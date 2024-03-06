<?php

namespace App\Http\Controllers;

use App\Models\BoutiquesModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;

class BoutiquesController extends Controller
{
    public function allBoutiques(){
        try{
            $allBoutiques = BoutiquesModel::all();
            $featuredProducts = ProductsModel::with(['boutique','subcategory'])->where('featured',true)->get();
            return response()->json([
                'allBoutiques'=>$allBoutiques,
                'featuredProducts'=>$featuredProducts
            ]);

        }catch(\Exception $e){
            dd($e->getMessage());
        }

    }

    public function thisBoutique($boutiqueName){

        $name = str_replace('-',' ',$boutiqueName);
        try{
            $boutique = BoutiquesModel::with('product')->where('name',$name)->first();

            if (!$boutique) {
                return response()->json(['message' => 'Boutique not found'], 404);
            }else{
                return response()->json($boutique);

            }

        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving boutique details'], 500);

        }
    }
}
