<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Erro;
use App\User;
use Gate;
use App\Setor; 

use App\Http\Controllers\Log;
use App\Http\Controllers\LogController;

class ErroController extends Controller
{
    
    /* ----------------------- LOGS ----------------------*/

    private function log($info){
        //path name
        $filename="ErroController";

        $log = new LogController;
        $log->store($filename, $info);
        return null;     
    }

    /* ----------------------- END LOGS --------------------*/

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        //LOG ----------------------------------------------------------------------------------------
        $this->log("erro.auth");
        //--------------------------------------------------------------------------------------------

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

            //LOG ----------------------------------------------------------------------------------------
            $this->log("erro");
            //--------------------------------------------------------------------------------------------

            return view('home.index'); 

        }else{
            return redirect('login')->with('danger', 'Erro: <b>400</b> Você não fez login no sistema');
        }
        
    }
}
