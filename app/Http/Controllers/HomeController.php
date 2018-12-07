<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Home;
use App\User;
use Gate;
use App\Setor; 

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


            /* ------------- Verifica perfil técnico ----------------- */

            $setores = Setor::all();

            $flagClient=0;

            foreach ($setores as $setor) {
                
                if(!(Gate::denies('read_'.$setor->name))){
                    return redirect('tecnicos/'.$setor->name.'/dashboard');
                }

            }


            return view('home.index'); 

        }else{
            return redirect('login')->with('danger', 'Erro: <b>400</b> Você não fez login no sistema');
        }
        
    }
}
