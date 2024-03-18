<?php

namespace App\Http\Controllers;

use App\Models\FavoriteModel;
use App\Models\ProductsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function addToFav($id){
        if(Auth::check()) {
            FavoriteModel::create([
                'product_id' => $id,
                'user_id' => Auth::user()->id
            ]);
        } else {
            // Ovdje možete obraditi slučaj kada korisnik nije prijavljen
        }
    }

    public function removeFromFavorites($id){
        $favorite = FavoriteModel::where('product_id', $id)->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Product removed from favorites'], 200);
        } else {
            return response()->json(['message' => 'Favorite not found'], 404);
        }
    }

    public function allFav(){
        $userId = Auth::user()->id;

        // Dobij sve favorite za trenutnog korisnika
        $myFavorites = FavoriteModel::where('user_id', $userId)->pluck('product_id');
        $myFavorites1 = FavoriteModel::where('user_id', $userId)->get();


        // Dobij sve proizvode koji su označeni kao favoriti
        $products = ProductsModel::with('boutique')->whereIn('id', $myFavorites)->get();

        return response()->json([$products,$myFavorites1]);
    }
}
