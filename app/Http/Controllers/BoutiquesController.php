<?php

namespace App\Http\Controllers;


use App\Models\BoutiquesModel;
use App\Repositories\BoutiquesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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


    public function addNewBoutique(Request $request){

        try {
            $requestData = $request->all();

            if($request->hasFile('image')){
                $image= $request->file('image');
                $imgName = time().'1.'.$image->extension();
                $image->move(public_path('images/'),$imgName);

            }

            if ($request->hasFile('image2')) {
                $image2 = $request->file('image2');
                $imgName2 = time().'2.'.$image2->extension();
                $image2->move(public_path('images/'), $imgName2);
            }


            if ($request->hasFile('image3')) {
                $image3 = $request->file('image3');
                $imgName3 = time().'3.'.$image3->extension();
                $image3->move(public_path('images/'), $imgName3);
            }

            $boutique = new BoutiquesModel;

            $boutique->name = $requestData['name'];
            $boutique->address = $requestData['address'];
            $boutique->email = $requestData['email'];
            $boutique->phone = $requestData['phone'];
            $boutique->description = $requestData['description'];
            $boutique->image = (isset($image)) ? $imgName : null;
            $boutique->image2 = (isset($image2)) ? $imgName2 : null;
            $boutique->image3 = (isset($image3)) ? $imgName3 : null;

            $boutique->save();
            return response()->json(['message' => 'Uspješno ste dodali butik'], 200);

        }catch (\Exception $e) {
        // Ukoliko se dogodi greška, vraćamo odgovor sa statusom 500
        Log::error(['message' => $e->getMessage()]);
        return response()->json(['error' => $e->getMessage(), 'trace' => $e->getTrace()], 500);
    }




    }
}
