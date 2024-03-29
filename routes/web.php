<?php

use App\Http\Controllers\BoutiquesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/products/all-products',[ProductController::class,'allProducts'])->name('allProducts');

Route::get('/{any}', function () {
    return view('home');
})->where('any', '.*');
