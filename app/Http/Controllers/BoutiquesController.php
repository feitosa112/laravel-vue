<?php

namespace App\Http\Controllers;

use App\Models\BoutiquesModel;
use Illuminate\Http\Request;

class BoutiquesController extends Controller
{
    public function allBoutiques(){
        try{
            $allBoutiques = BoutiquesModel::all();
            return response()->json($allBoutiques);

        }catch(\Exception $e){
            dd($e->getMessage());
        }

    }

    public function thisBoutique($boutiqueId){
        try{
            $boutique = BoutiquesModel::with('product')->findOrFail($boutiqueId);

            return response()->json($boutique);
        }catch(\Exception $e){
            dd($e->getMessage());

        }
    }
}
