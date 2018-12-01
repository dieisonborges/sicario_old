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
use App\User;
use DB;

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

    private function autenticacao()
    {
        
        $code = md5(date("YmdHisu").rand());

        return $code;
    }

    private function weekBr(){
        /*
        Sunday      Domingo
        Monday      Segunda
        Tuesday     Terça
        Wednesday   Quarta
        Thursday    Quinta
        Friday      Sexta
        Saturday    Sábado
        */

        $week = array(
            'Sunday' => 'Domingo',
            'Monday' => 'Segunda',
            'Tuesday' => 'Terça',
            'Wednesday' => 'Quarta',
            'Thursday' => 'Quinta',
            'Friday' => 'Sexta',
            'Saturday' => 'Sábado',
        );

        return $week;
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

            $users = $setor->users()->get();

            $livros = $setor->livros()->paginate(40);

            $week = $this->weekBr();

            $semana = "olá";

            return view('livro.index', array('week' => $week, 'users' => $users, 'setor' => $setor, 'livros' => $livros, 'buscar' => null));
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

            $users = $setor->users()->get();

            return view('livro.create', compact('setor', 'users'));
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
        
        $setor = $request->input('setor');

        //
        if(!(Gate::denies('read_'.$setor))){

            //Validação
            $this->validate($request,[
                    'inicio_hora' => 'required',
                    'inicio_data' => 'required|date',
                    'fim_hora' => 'required',
                    'fim_data' => 'required|date',
                    'tecnicos' => 'required',
                    
            ]);
           

            $livro = new Livro();

            $livro->inicio = $request->input('inicio_data').' '.$request->input('inicio_hora');

            $livro->fim = $request->input('fim_data').' '.$request->input('fim_hora');

            $tecnicos = $request->input('tecnicos');

            //dd($request->input('tecnicos'));

            $livro->setor_id = $request->input('setor_id');

            $livro->protocolo = $this->protocolo($setor);

            $livro->autenticacao = $this->autenticacao();

            //usuário
            $livro->user_id = auth()->user()->id;

            /* ------------------------------------Conteudo Livro-------------------------------- */

            //cabecalho
            $conteudo = "";

            $setor = Setor::find($request->input('setor_id'));

            //Tickets Abertos por setor
            $tickets = $setor->tickets()->where("status", "0")->get();
            //lista os tickets
            foreach($tickets as $ticket){
                //Verifica se ticket está dentro do intervalo de data
                if(($ticket->created_at)){
                        $conteudo .= "<li>";
                        $conteudo .= " Ticket: <b>".$ticket->protocolo."</b><br>";
                        $conteudo .= "".$ticket->titulo."<br>";
                        $prontuarios = $ticket->prontuarioTicketsShow()->get();
                        //lista os prontuarios dos tickets
                        $conteudo .= "<ul>";
                        foreach($prontuarios as $prontuario){
                            $conteudo .= "<li>";
                            $user_prontuario = User::find($prontuario->user_id);
                            $conteudo .= "<small><b>".$prontuario->created_at."</b></small> ";
                            $conteudo .= $user_prontuario->cargo." ".$user_prontuario->name."<br>";
                            
                            $conteudo .= "".preg_replace('/<[^>]*>/', '', $prontuario->descricao)."<br>";
                            $conteudo .= "</li>";
                    }
                }
                $conteudo .= "</ul>";
                $conteudo .= "</li><br><br>";
            }           

            /* -------------------------------------FIM Conteudo Livro---------------------------- */
            

            $livro->conteudo = $conteudo;  

            $livro->acoes = $conteudo;  
            


            if($livro->save()){
                $livro_id = DB::getPdo()->lastInsertId();
                //Vincula tecnicos ao livro
                foreach ($tecnicos as $tecnico) {
                    Livro::find($livro_id)->livroUser()->attach($tecnico);
                }                

                return redirect('livros/'.$setor->name.'/'.$livro_id.'/show')->with('success', 'Verifique o Livro!');
            }else{
                return redirect('livros/'.$setor->name)->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
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

            $tecnicos = $livro->userLivros()->get();

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

            

            return view('livro.show', compact('livro', 'setor', 'tecnicos'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }

}
