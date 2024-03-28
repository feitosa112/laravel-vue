<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function contactMsg(Request $request){
    Log::info('Pozvana je contactMsg funkcija.');

    $message = $request->input('message');
    $user_id = Auth::user()->id;

    ContactModel::create([
        'user_id'=>$user_id,
        'message'=>$message,
    ]);

    return response()->json(['message'=>'Uspjesno ste poslali poruku'],500);
    }
}
