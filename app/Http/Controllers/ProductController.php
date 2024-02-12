<?php

namespace App\Http\Controllers;

use App\Models\ProductsModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductsWithSubCategory($subcategory_id){
        try{
            $products = ProductsModel::where('subcategory_id',$subcategory_id)->get();
            if (!$products) {
                return response()->json(['message' => 'Products not found'], 404);
            }else{
                return response()->json($products);

            }
        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving products details'], 500);

        }
    }

    public function getProductsWithCategory($category_id){
        try{
            $products = ProductsModel::where('category_id',$category_id)->get();
            if (!$products) {
                return response()->json(['message' => 'Products not found'], 404);
            }else{
                return response()->json($products);

            }
        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving products details'], 500);

        }
    }


    public function getThisProduct($id,$productName){
        $name = str_replace('-',' ',$productName);

        try {
            $product = ProductsModel::with('boutique')->where('id',$id)->where('name',$name)->first();
                if(!$product){
                return response()->json(['message' => 'Product not found'], 404);

                }else{
                    return response()->json($product);
                }
        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving product details'], 500);

        }
    }
}
