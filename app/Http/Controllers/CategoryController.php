<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductsModel;
use App\Models\SubcategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function allCategories(){
        try {
            $allCategories = CategoryModel::with('withSubCategory')->get();

            foreach($allCategories as $category){
                $productsInCategory = ProductsModel::all();
            }
            if(!$allCategories){
                return response()->json(['message' => 'Error category'], 404);
            }else{
                return response()->json([
                    'allCategories'=>$allCategories,
                    'productsInCategory'=>$productsInCategory
                ]);

            }

        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving categories'], 500);

        }

    }

    public function allSubCategories($id){
        $subcategories = SubcategoryModel::where('category_id',$id)->get();
        return response()->json($subcategories);
    }
}
