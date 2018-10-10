<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Home;
use App\User;
use Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        
        if(Auth::check()){
            return view('home.index');  
        }else{
            return redirect('login')->with('danger', 'Erro: <b>400</b> Você não fez login no sistema');
        }
        
    }
}
