<?php

namespace App\Http\Controllers;

use App\Models\BoutiquesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        // dd($user1['email']);


        return view('home',['user'=>$user]);
    }

    public function userBoutique($id){
        $user = User::find($id);
        $boutique = BoutiquesModel::where('email',$user->email)->get();
        return response()->json($boutique);
    }
}
