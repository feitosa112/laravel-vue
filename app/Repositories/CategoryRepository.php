<?php

namespace App\Repositories;

use App\Models\CategoryModel;
use App\Models\ProductsModel;

class CategoryRepository {
    private $categoryModel;

    public function __construct(CategoryModel $categoryModel){
        $this->categoryModel = $categoryModel;
    }

    public function getAllCategories(){
        try {
            $allCategories = CategoryModel::with('withSubCategory')->get();

            foreach($allCategories as $category){
                $productsInCategory = ProductsModel::all();
            }
            if(!$allCategories){
                return response()->json(['message' => 'Error category'], 404);
            }else{
                return ([
                    'allCategories'=>$allCategories,
                    'productsInCategory'=>$productsInCategory
                ]);

            }

        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving categories'], 500);

        }
    }
}
