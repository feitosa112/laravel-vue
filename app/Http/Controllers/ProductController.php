<?php

namespace App\Http\Controllers;

use App\Models\BoutiquesModel;
use App\Models\ProductsModel;
use App\Models\SubcategoryModel;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    private $productsRepo;

    public function __construct(ProductRepository $productsRepo){
        $this->productsRepo = $productsRepo;
    }
    public function getProductsWithSubCategory($subcategory_id){
        $products = $this->productsRepo->getProductsWithSubCategory($subcategory_id);
        if($products){
            return response()->json($products);
        }else {
            return response()->json(['message' => 'Products not found'], 404);
        }
    }



    public function getProductsWithCategory($category_id){
        $products = $this->productsRepo->getProductsWithCategory($category_id);
        if($products){
            return response()->json($products);
        }else{
            return response()->json(['message' => 'Products not found'], 404);
        }
    }


    public function getThisProduct($id,$productName){
        $product = $this->productsRepo->getThisProduct($id,$productName);

        if($product){
            return response()->json($product);
        }else{
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    public function addToCart(Request $request) {

        $formData = $request->all();

        $color = $formData['color'];
        $size = $formData['size'];
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

public function allProducts(Request $request)
    {
        try {
            $perPage = $request->get('perPage', 4); // Broj proizvoda po stranici
            $products = ProductsModel::with('boutique')->paginate($perPage);
            $allProducts = ProductsModel::with('boutique')->get();

            return response()->json([$products,$perPage,$allProducts])->header('Content-Type', 'application/json; charset=utf-8');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
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

public function deleteProduct($id) {
    try {
        $product = ProductsModel::findOrFail($id);
        $product->delete();

        Log::info('Proizvod je uspješno obrisan.', ['product_id' => $id]);

        return response()->json(['message' => 'Uspješno brisanje proizvoda']);
    } catch (\Exception $e) {
        Log::error('Došlo je do greške prilikom brisanja proizvoda.', ['product_id' => $id, 'exception' => $e->getMessage()]);

        return response()->json(['message' => 'Došlo je do greške prilikom brisanja proizvoda.'], 500);
    }
}











    }





