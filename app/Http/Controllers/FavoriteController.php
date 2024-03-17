<?php

namespace App\Http\Controllers;

use App\Models\FavoriteModel;


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
        $favorite = FavoriteModel::where('product_id',$id)->get()->first();

        if ($favorite) {
            $favorite->delete();
        }
        return redirect()->back();

    }

    public function allFav(){
        $userId = Auth::user()->id;
        $products = FavoriteModel::where('user_id',$userId)->get();
        return response()->json($products);
    }
}
