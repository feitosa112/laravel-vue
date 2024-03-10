<?php

namespace App\Http\Controllers;


use App\Repositories\BoutiquesRepository;


class BoutiquesController extends Controller
{
    private $boutiquesRepo;

    public function __construct(BoutiquesRepository $boutiquesRepo){
        $this->boutiquesRepo = $boutiquesRepo;
    }
    public function allBoutiques(){
       $allBoutiques = $this->boutiquesRepo->getAllBoutiques();
       return response()->json($allBoutiques);
    }

    public function thisBoutique($boutiqueName){

        $boutique = $this->boutiquesRepo->getThisBoutique($boutiqueName);
        if($boutique){
            return response()->json($boutique);

        }else{
            return response()->json(['message' => 'Boutique not found'], 404);
        }
    }
}
