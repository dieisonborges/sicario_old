<?php

namespace App\Http\Controllers;

use App\Livro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
//use Request;
use Gate;
use App\Equipamento;
use App\Setor;
use App\Ticket;

class LivroController extends Controller
{
    
    private $livro;

    public function __construct(Livro $livro){
        $this->livro = $livro;        
    }

    private function protocolo($setor)
    {
        
        $chars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';

        $protocolo = $chars[rand (0 , 25)];
        $protocolo .= $chars[rand (0 , 25)];
        $protocolo .= rand (0 , 9);
        $protocolo .= rand (0 , 9);
        $protocolo .= rand (0 , 9);
        $protocolo .= rand (0 , 9);

        return "L".date("Y").$protocolo."/".$setor;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($setor)
    {
        //
        if(!(Gate::denies('read_'.$setor))){

            //usuário
            //$user_id = auth()->user()->id;

            //setor
            $setors = Setor::where('name', $setor)->limit(1)->get();

            foreach ($setors as $setor ) {
                $temp_setor = $setor;
            }

            $setor = $temp_setor;

            $livros = $setor->livros()->paginate(40);


            return view('livro.index', array('setor' => $setor, 'livros' => $livros, 'buscar' => null));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($setor) 
    {
        //
        if(!(Gate::denies('read_'.$setor))){

            $setors = Setor::where('name', $setor)->limit(1)->get();

            foreach ($setors as $setor ) {
                $temp_setor = $setor;
            }

            $setor = $temp_setor;

            return view('livro.create', compact('setor'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Livro  $livro
     * @return \Illuminate\Http\Response
     */
    public function show($setor, $id)
    {    
        //
        if(!(Gate::denies('read_'.$setor))){
            $livro = Livro::find($id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao livro
            $setors_security = $livro->setors()->where('name', $setor)->get();
            foreach ($setors_security as $setor_sec ) {
                $setors_security = $setor_sec;
            }

            if(!(isset($setors_security->id))){
                //return redirect('home')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            return view('livro.show', compact('livro', 'setor'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }

}
