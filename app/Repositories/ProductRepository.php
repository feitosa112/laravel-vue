<?php
namespace App\Repositories;

use App\Models\ProductsModel;
use App\Models\SubcategoryModel;
use Illuminate\Support\Facades\Auth;

class ProductRepository {
    private $productsModel;
    public function __construct(ProductsModel $productsModel){
        $this->productsModel = $productsModel;
    }


    public function getProductsWithSubCategory($subcategory_id){
        try{
            $products = ProductsModel::with(['boutique','subcategory'])->where('subcategory_id',$subcategory_id)->get();
            if (!$products) {
                return response()->json(['message' => 'Products not found'], 404);
            }else{
                return ($products);

            }
        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving products details'], 500);

        }
    }


    public function getProductsWithCategory($category_id){
        try{
            $products = ProductsModel::with('boutique')->where('category_id',$category_id)->get();
            $subCategory = SubcategoryModel::where('category_id',$category_id)->get();
            if (!$products) {
                return response()->json(['message' => 'Products not found'], 404);
            }else{
                return ([
                    'products' => $products,
                    'subCategory' => $subCategory,
                ]);

            }
        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving products details'], 500);

        }
    }


    public function getThisProduct($id,$productName){
        $name = str_replace('-',' ',$productName);

        try {
            $product = ProductsModel::with('boutique')->where('id',$id)->where('name',$name)->first();

            if(Auth::user() && Auth::user()->email !== $product->boutique[0]->email && Auth::user() && Auth::user()->email !== '112kuzmanovic@gmail.com' || !Auth::user() ){
                $product->increment('view');
            }else{
                $product->view = $product->view;
            }
                if(!$product){
                return response()->json(['message' => 'Product not found'], 404);

                }else{
                    return ($product);
                }
        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving product details'], 500);

        }
    }



}
