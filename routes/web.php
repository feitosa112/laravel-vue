<?php

use App\Http\Controllers\BoutiquesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(BoutiquesController::class)->group(function(){
    Route::get('/allBoutiques','allBoutiques')->name('allBoutiques');

});
Route::get('/{boutiqueName}',[BoutiquesController::class,'thisBoutique'])->name('boutique-page');
