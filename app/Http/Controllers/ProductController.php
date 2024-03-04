<?php

namespace App\Http\Controllers;

use App\Models\ProductsModel;
use App\Models\SubcategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function getProductsWithSubCategory($subcategory_id){
        try{
            $products = ProductsModel::with(['boutique','subcategory'])->where('subcategory_id',$subcategory_id)->get();
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
            $products = ProductsModel::with('boutique')->where('category_id',$category_id)->get();
            $subCategory = SubcategoryModel::where('category_id',$category_id)->get();
            if (!$products) {
                return response()->json(['message' => 'Products not found'], 404);
            }else{
                return response()->json([
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
                if(!$product){
                return response()->json(['message' => 'Product not found'], 404);

                }else{
                    return response()->json($product);
                }
        }catch(\Exception $e){
            return response()->json(['message' => 'Error retrieving product details'], 500);

        }
    }

    public function addToCart(Request $request) {
        // $id je vrednost uhvaćena iz URL rute
        // Session::forget('cart');
        // Uzimanje podataka iz tela HTTP POST zahteva
        $formData = $request->all();

        // Rad sa podacima iz tela zahteva i $id

        // Primer: Dodavanje proizvoda u korpu


        $color = $formData['color']; // Prilagodite ključu prema strukturi vašeg tela zahteva
        $size = $formData['size']; // Prilagodite ključu prema strukturi vašeg tela zahteva
        $boutiqueName = $formData['boutiqueName'];
        $id = $formData['id'];
        $product = ProductsModel::with('boutique')->find($id);

        // Dalja logika za dodavanje u korpu
        $cart = Session::get('cart', []);
        foreach ($cart as $item) {
            if ($item['productId'] == $product->id && $item['size'] == $size && $item['color'] == $color) {
                return response()->json(['message' => 'Proizvod već u korpi'], 401);
            }
        }
        // Dodavanje novog proizvoda u korpu
        $cart[] = [
            'productId'=>$product->id,
            'productName'=>$product->name,
            'boutiqueName'=>$boutiqueName,
            'color' => $color,
            'size' => $size,
            'price'=>$product->price,
            'cart_quantity'=>$product->cart_quantity,
            'cart_total'=>$product->cart_total
        ];

        // Čuvanje ažurirane korpe u sesiji
        Session::put('cart', $cart);

        // Vraćanje odgovora
        return response()->json($cart);
    }

    public function cartView() {
        // dd(Session::all());
        // Dobijanje trenutnog sadržaja korpe iz sesije
        $cart = Session::get('cart',[]);

        // Vraćanje odgovora
        return response()->json($cart);
    }

    public function emptyCart(Request $request){
        $cart = Session::get('cart',[]);

        Session::forget('cart');

        return response()->json(['message'=>'Ispraznili ste svoju korpu']);
    }



public function deleteProductFromCart(Request $request) {

        $requestData = $request->all();
        $productId = $requestData['productId'];
        $color = $requestData['color'];
        $size = $requestData['size'];

        $cart = Session::get('cart', []);

    try {
        // Uzimanje parametara iz tela zahteva


        Log::info("Deleting product from cart: ProductId: $productId, Color: $color, Size: $size");

        // Dobijanje korpe iz sesije


        foreach ($cart as $index => $product) {
            if ($product['productId'] === $productId && $product['color'] === $color && $product['size'] === $size) {
                unset($cart[$index]);

            }
        }


            // Ažuriranje korpe u sesiji
            Session::put('cart', $cart);
            return response()->json(['message' => 'Izbrisali ste proizvod iz korpe'],200);

    } catch (\Exception $e) {
        // Dodajte informacije o grešci
        $errorMessage = 'Error deleting product from cart: ' . $e->getMessage();
        Log::error($errorMessage);

        // Vrati odgovor sa statusom 500 i dodatnim informacijama o grešci
        return response()->json(['error' => $errorMessage], 500);
    }
}

    public function allProducts(){
        DB::listen(function ($query) {
            Log::info($query->sql, $query->bindings, $query->time);
        });
        try {
            $products = ProductsModel::with('boutique')->get();

            if($products){
                return response()->json($products)->header('Content-Type', 'application/json; charset=utf-8');
            }else{
                return response()->json(['message'=>'nisu pronadjeni proizvodi']);
            }
        }catch(\Exception $e){
            return response()->json(['error'=>$e->getMessage()],500);
        }
    }


    public function addNewProduct(Request $request)
{
    Log::info('Pozvana je addNewProduct funkcija.');

    try {
        $requestData = $request->all();
        $boutique=$requestData['boutique_name'];
        // Provera i čuvanje slika

        if($request->hasFile('image1')){
            $image1= $request->file('image1');
            $imgName = time().'1.'.$image1->extension();
            $image1->move(public_path('images/'.$boutique),$imgName);

        }


if ($request->hasFile('image2')) {
    $image2 = $request->file('image2');
    $imgName2 = time().'2.'.$image2->extension();
    $image2->move(public_path('images/'.$boutique), $imgName2);
}


if ($request->hasFile('image3')) {
    $image3 = $request->file('image3');
    $imgName3 = time().'3.'.$image3->extension();
    $image3->move(public_path('images/'.$boutique), $imgName3);
}

        // Kreiranje instance modela
        $product = new ProductsModel;

        // Postavljanje vrednosti
        $product->name = $requestData['name'];
        $product->category_id = $requestData['category_id'];
        $product->subcategory_id = $requestData['subcategory_id'];
        $product->boutique_id = $requestData['boutique_id'];
        $product->image1 = (isset($image1)) ? $imgName : null;
        $product->image2 = (isset($image2)) ? $imgName2 : null;
        $product->image3 = (isset($image3)) ? $imgName3 : null;
        $product->price = floatval($requestData['price']);
        $product->old_price = floatval($requestData['old_price']);
        $product->color = $requestData['color'];
        $product->size = $requestData['size'];
        $product->cart_quantity = 1;
        $product->cart_total = floatval($requestData['price']);
        $product->description = $requestData['description'];
        $product->featured = 0;

        // Čuvanje proizvoda
        $product->save();

        return response()->json(['message' => 'Uspješno ste dodali proizvod'], 200);
    } catch (\Exception $e) {
        // Ukoliko se dogodi greška, vraćamo odgovor sa statusom 500
        Log::error(['message' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTrace()], 500);
    }
}








    }





