<?php

use App\Http\Controllers\BoutiquesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
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
Route::controller(BoutiquesController::class)->group(function(){
    Route::get('/allBoutiques','allBoutiques')->name('allBoutiques');
    Route::get('/{boutiqueName}','thisBoutique')->name('boutique-page');
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/sub-category/{subcategory_id}/detail','getProductsWithSubCategory')->name('getProductsWithSubCategory');
    Route::get('/category/{category_id}','getProductsWithCategory')->name('getProductsWithCategory');
    Route::get('/product/{id}/{productName}','getThisProduct')->name('thisProduct');
    Route::get('/all-products','allProducts')->name('allProducts');
    Route::post('/add-new-product','addNewProduct')->name('addNewProduct');
});

Route::controller(CategoryController::class)->group(function(){
    Route::get('/boutique/allCategories','allCategories')->name('allCategories');
    Route::get('/category/sub-cat/{id}','allSubCategories')->name('allSubCategories');
});


    Route::get('/user/email/{id}',[HomeController::class,'userBoutique'])->name('userBoutique');


    Route::middleware('web')->group(function () {
        Route::prefix('cart')->group(function () {
            Route::post('/addToCart', [ProductController::class, 'addToCart'])->name('addToCart');
            Route::get('/cart-view', [ProductController::class, 'cartView'])->name('cartView');
            Route::post('/empty-cart', [ProductController::class, 'emptyCart'])->name('emptyCart');
            Route::post('/delete-product', [ProductController::class, 'deleteProductFromCart'])->name('deleteProductFromCart');

        });

        Route::group(['prefix' => 'order'], function () {
            Route::post('/send-order', [OrderController::class, 'sendOrder'])->name('sendOrder');
        });

        Route::get('/products/theBestSellingsProduct', [OrderController::class, 'theBestSellingProducts'])->name('theBestSellingProducts');
    });

    Route::prefix('admin')->group(function(){
        Route::post('/add-new-boutique',[BoutiquesController::class,'addNewBoutique'])->name('addNewBoutique');
    });

    Route::controller(FavoriteController::class)->group(function(){
        Route::get('product/add-to-fav/{id}','addToFav')->middleware('auth')->name('addToFav');
        Route::get('product/remove-fav/{id}', 'removeFromFavorites')->middleware('auth')->name('removeFromFavorites');
        Route::get('products/all-fav','allFav')->name('allFav');
    });



Route::fallback(function () {
    return response()->json(['message' => 'Fallback route.'], 404);
});

Route::get('/user/isLoged',[HomeController::class,'getLogedUser'])->name('isLogedUser');

Route::get('/{any}', function () {
    return view('home');
})->where('any', '.*');



