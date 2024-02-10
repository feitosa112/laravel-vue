<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function allCategories(){
        try {
            $allCategories = CategoryModel::with('withSubCategory')->get();
            if(!$allCategories){
                return response()->json(['message' => 'Error category'], 404);
            }else{
                return response()->json($allCategories);

            }

        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving categories'], 500);

        }

    }
}
