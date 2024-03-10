<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductsModel;
use App\Models\SubcategoryModel;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo){
        $this->categoryRepo = $categoryRepo;
    }
    public function allCategories(){
       $allCetegories = $this->categoryRepo->getAllCategories();

       if($allCetegories){
        return response()->json($allCetegories);
       }else{
        return response()->json(['message' => 'Error category'], 404);
       }

    }

    public function allSubCategories($id){
        $subcategories = SubcategoryModel::where('category_id',$id)->get();
        return response()->json($subcategories);
    }
}
