<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function contactMsg(Request $request)
{
    Log::info('Pozvana je contactMsg funkcija.');

    try {
        // Zapisi informaciju u log datoteku

        // Dobavi sve podatke iz zahtjeva
        $requestData = $request->all();

        // Provjeri postoji li prijavljeni korisnik
        if (Auth::check()) {
            // Ako postoji prijavljeni korisnik, dohvati njegov ID
            $user_id = Auth::user()->id;
        } else {
            // Ako korisnik nije prijavljen, postavi korisnički ID na null
            $user_id = null;
        }

        // Dohvati poruku iz podataka zahtjeva
        $message = $requestData['message'];

        // Kreiraj novi unos u tablici kontakata
        ContactModel::create([
            'user_id' => $user_id,
            'message' => $message,
        ]);

        // Vrati odgovor korisniku s porukom o uspješnom slanju
        return response()->json(['message' => 'Uspješno ste poslali poruku'], 200);
    } catch (\Exception $e) {
        // Uhvati iznimku ako dođe do greške
        Log::error('Greška prilikom slanja poruke: ' . $e->getMessage());

        // Vrati odgovor korisniku s porukom o grešci
        return response()->json(['message' => 'Došlo je do greške prilikom slanja poruke'], 500);
    }
}

}
