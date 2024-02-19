<?php

use App\Http\Controllers\BoutiquesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(BoutiquesController::class)->group(function(){
    Route::get('/allBoutiques','allBoutiques')->name('allBoutiques');
    Route::get('/{boutiqueName}','thisBoutique')->name('boutique-page');


});
Route::controller(ProductController::class)->group(function(){
    Route::get('/products/{subcategory_id}','getProductsWithSubCategory')->name('getProductsWithSubCategory');
    Route::get('products/{category_id}','getProductsWithCategory')->name('getProductsWithCategory');
    Route::get('/product/{id}/{productName}','getThisProduct')->name('thisProduct');


});
Route::get('/boutique/allCategories',[CategoryController::class,'allCategories'])->name('allCategories');

Route::group(['middleware' => 'web'], function () {
    Route::post('/cart/addToCart',[ProductController::class,'addToCart'])->name('addToCart');
    Route::get('/cart/cart-view', [ProductController::class, 'cartView'])->name('cartView');
    Route::post('/cart/empty-cart',[ProductController::class,'emptyCart'])->name('emptyCart');
    Route::post('/cart/delete-product',[ProductController::class,'deleteProductFromCart'])->name('deleteProductFromCart');
});

Route::fallback(function () {
    return response()->json(['message' => 'Fallback route.'], 404);
});

Route::get('/user/isLoged',[HomeController::class,'getLogedUser'])->name('isLogedUser');

Route::get('/{any}', function () {
    return view('home');
})->where('any', '.*');
