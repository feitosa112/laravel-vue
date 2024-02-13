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

});
Route::get('/boutique/allCategories',[CategoryController::class,'allCategories'])->name('allCategories');


Route::get('/{boutiqueName}',[BoutiquesController::class,'thisBoutique'])->name('boutique-page');

Route::get('/products/{subcategory_id}',[ProductController::class,'getProductsWithSubCategory'])->name('getProductsWithSubCategory');
Route::get('products/{category_id}',[ProductController::class,'getProductsWithCategory'])->name('getProductsWithCategory');
Route::get('/product/{id}/{productName}',[ProductController::class,'getThisProduct'])->name('thisProduct');

Route::get('/user/isLoged',[HomeController::class,'getLogedUser'])->name('isLogedUser');
