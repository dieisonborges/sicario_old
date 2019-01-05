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
use Carbon\Carbon;

//Log
use App\Http\Controllers\Log;
use App\Http\Controllers\LogController;

class LivroController extends Controller
{
    
    /* ----------------------- LOGS ----------------------*/

    private function log($info){
        //path name
        $filename="LivroController";

        $log = new LogController;
        $log->store($filename, $info);
        return null;     
    }

    /* ----------------------- END LOGS --------------------*/


    private $livro;

    public function __construct(Livro $livro){
        $this->livro = $livro;        
    }

    private function protocolo($setor)
    {
        
        $chars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';

        $protocolo = $chars[rand (0 , 24)];
        $protocolo .= $chars[rand (0 , 24)];
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
            $setor = Setor::where('name', $setor)->first();


            $users = $setor->users()->get();

            $livros = $setor->livros()->orderBy('id','DESC')->paginate(40);

            $week = $this->weekBr();

            //LOG ----------------------------------------------------------------------------------------
            $this->log("livro.index");
            //--------------------------------------------------------------------------------------------

            return view('livro.index', array('week' => $week, 'users' => $users, 'setor' => $setor, 'livros' => $livros, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function busca (Request $request, $setor){
        //
        if(!(Gate::denies('read_'.$setor))){

            $buscaInput = $request->input('busca');
            

            //usuário
            //$user_id = auth()->user()->id;

            //setor
            $setor = Setor::where('name', $setor)->first();
            
            $livros = $setor->livros()
                                ->where(function($query) use ($buscaInput) {
                                    $query->where('inicio', 'LIKE', '%'.$buscaInput.'%')
                                    ->orwhere('fim', 'LIKE', '%'.$buscaInput.'%')
                                    ->orwhere('autenticacao', 'LIKE', '%'.$buscaInput.'%')
                                    ->orwhere('protocolo', 'LIKE', '%'.$buscaInput.'%')
                                    ->orwhere('conteudo', 'LIKE', '%'.$buscaInput.'%')
                                    ->orwhere('acoes', 'LIKE', '%'.$buscaInput.'%');
                                })
                                ->orderBy('id','DESC')
                                ->paginate(40);


            $users = $setor->users()->get();

            $week = $this->weekBr();

            //LOG ----------------------------------------------------------------------------------------
            $this->log("livro.index.busca=".$buscaInput);
            //--------------------------------------------------------------------------------------------

            return view('livro.index', array('week' => $week, 'users' => $users, 'setor' => $setor, 'livros' => $livros, 'buscar' => $buscaInput));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
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

            $setor = Setor::where('name', $setor)->first();


            $users = $setor->users()->get();

            //LOG ----------------------------------------------------------------------------------------
            $this->log("livro.create");
            //--------------------------------------------------------------------------------------------

            return view('livro.create', compact('setor', 'users'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
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

            /* ------------------------------------Acoes para o proximo Serviço-------------------------------- */

            //cabecalho
            $acoes = "";

            $setor = Setor::find($request->input('setor_id'));

            //Tickets Abertos por setor
            // 1 - Aberto/Ativo
            // 0 - Fechado/Encerrado
            $tickets = $setor->tickets()->where("status", "1")->get();
            //lista os tickets
            foreach($tickets as $ticket){
                //Verifica se ticket está dentro do intervalo de data
                        $acoes .= "<li> ";
                        $acoes .= " Ticket: <b>".$ticket->protocolo."</b> ";
                        $acoes .= "<small>".date('d/m/Y H:i:s', strtotime($ticket->created_at))."</small> <br>";
                        $acoes .= "<small>".$setor->name."</small> <br>";
                        $user_ticket_acoes = User::find($ticket->user_id);
                        $acoes .= strtoupper($user_ticket_acoes->cargo)." ".strtoupper($user_ticket_acoes->name)."<br>";
                        $acoes .= "".$ticket->titulo."<br> ";
                        $acoes .= "".preg_replace('/<[^>]*>/', '', $ticket->descricao)."<br>"; 
                        $prontuarios = $ticket->prontuarioTicketsShow()->get();
                        //lista os prontuarios dos tickets
                        $acoes .= "<ul>";
                        
                        foreach($prontuarios as $prontuario){
                            $acoes .= "<li>";
                            $user_prontuario = User::find($prontuario->user_id);
                            $acoes .= "<small><b>".$prontuario->created_at."</b></small> ";
                            $acoes .= strtoupper($user_prontuario->cargo)." ".strtoupper($user_prontuario->name)."<br>";                            
                            $acoes .= "".preg_replace('/<[^>]*>/', '', $prontuario->descricao)."<br>";
                            $acoes .= "</li>";
                        }

                $acoes .= "</ul>";
                $acoes .= "</li><br><br>";
            }
            /* ------------------------------------FIM Acoes para o proximo Serviço-------------------------------- */ 

            //Caso Conteúdo vazio nenhuma Alteração
            if(!$acoes){

                $acoes = "Nenhuma alteração.";
            }    

            //Armazena para inserir no banco
            $livro->acoes = $acoes;  

            /* ------------------------------------Conteudo Livro -------------------------------- */     
            //Verifica se o ticket ou alguma ação compreende o período do serviço
            //$srvFlag = 0;

            //cabecalho
            $conteudo = "";

            //$conteudo_temp = "";

            $setor = Setor::find($request->input('setor_id'));

            //Tickets Abertos por setor
            // 1 - Aberto/Ativo
            // 0 - Fechado/Encerrado
            $tickets = $setor->tickets()
                             ->where('status', '0')
                             ->get();

            
            $livro_inicio = strtotime($livro->inicio);
            $livro_fim = strtotime($livro->fim);

            //Verificação de intervalo de data
            $matchData=0;


            //$conteudo .= "<ol>";
            foreach ($tickets as $ticket) {

                /* --------------------------- Verifica intervalo de data ---------------------- */
                $created_at = strtotime(Carbon::parse($ticket->created_at)->format('Y-m-d H:i:s'));

                if(($created_at>=$livro_inicio)and($created_at<=$livro_fim)){
                    $matchData=1;
                } 

                $prontuarios = $ticket->prontuarioTicketsShow()->get();

                foreach($prontuarios as $prontuario){

                    $prontuario_created_at = strtotime(Carbon::parse($prontuario->created_at)->format('Y-m-d H:i:s'));

                    if(($prontuario_created_at>=$livro_inicio)and($prontuario_created_at<=$livro_fim)){
                        $matchData=1;
                    } 

                }


                /* --------------------------- FIM Verifica intervalo de data ---------------------- */


                /* --------------------- */

                if($matchData==1){
                    //HTML
                    $conteudo .= "<li>";
                    $conteudo .= " Ticket: <b>".$ticket->protocolo."</b><br>";
                    $user_ticket = User::find($ticket->user_id);
                    $conteudo .= strtoupper($user_ticket->cargo)." ".strtoupper($user_ticket->name)."<br>";
                    $conteudo .= "<small>".date('d/m/Y H:i:s', strtotime($ticket->created_at))."</small><br>";
                    $conteudo .= "".$ticket->titulo."<br>";
                    $conteudo .= "".preg_replace('/<[^>]*>/', '', $ticket->descricao)."<br>"; 

                    $conteudo .= "<ul>";
                    /* -----------------PRONTUARIO/ACOES---------------------*/
                    foreach($prontuarios as $prontuario){

                        $conteudo .= "<li>";
                        $user_prontuario = User::find($prontuario->user_id);
                        $conteudo .= "<small>".date('d/m/Y H:i:s', strtotime($ticket->created_at))."</small> ";
                        $conteudo .= "<small>".$setor->name."</small> ";
                        $conteudo .= strtoupper($user_prontuario->cargo)." ".strtoupper($user_prontuario->name)."<br> ";
                        
                        $conteudo .= "".preg_replace('/<[^>]*>/', '', $prontuario->descricao)."<br> ";
                        $conteudo .= "</li>";

                    }
                    /* ----------------END PRONTUARIO/ACOES-------------------*/
                    $conteudo .= "</ul>";
                    $conteudo .= "</li>";
                }

                /* --------------------- */


                //Zera verificação de intervalo de data
                $matchData=0;
                
            }

            //Caso Conteúdo vazio nenhuma Alteração
            if(!$conteudo){

                $conteudo = "Nenhuma alteração.";
            }

          
            
            //Armazena para inserir no banco
            $livro->conteudo = $conteudo;  

            //LOG ----------------------------------------------------------------------------------------
            $this->log("livro.store");
            //--------------------------------------------------------------------------------------------

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
            return redirect('erro')->with('permission_error', '403');
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
                //return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            //LOG ----------------------------------------------------------------------------------------
            $this->log("livro.show.id=".$id);
            //--------------------------------------------------------------------------------------------
            

            return view('livro.show', compact('livro', 'setor', 'tecnicos'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function aprovar($setor, $id)
    {
        //
        if(!(Gate::denies('update_'.$setor))){
            $livro = Livro::find($id); 



            if($livro->status==1){
                return redirect()->back()->with('danger','O Livro não pode ser excluído!');
            }

            $livro->status = 1;

            //LOG ----------------------------------------------------------------------------------------
            $this->log("livro.aprovar.id=".$id);
            //--------------------------------------------------------------------------------------------

            if($livro->save()){
                return redirect()->back()->with('success','Livro APROVADO.');
            }else{
                return redirect('livros/'.$setor.'/')->with('danger','Ouve um problema!');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
            
            
    }

    public function destroy($setor, $id)
    {
        //
        if(!(Gate::denies('delete_'.$setor))){
            $livro = Livro::find($id);      

            if($livro->status==1){

                //LOG ----------------------------------------------------------------------------------------
                $this->log("livro.index=Não pode ser excluido! id".$id);
                //--------------------------------------------------------------------------------------------
                
                return redirect()->back()->with('danger','O Livro não pode ser excluído!');

            }else{

                $livro->delete();

                //LOG ----------------------------------------------------------------------------------------
                $this->log("livro.destroy.id=".$id);
                //--------------------------------------------------------------------------------------------

                return redirect('livros/'.$setor.'/')->with('success','Livro excluído com sucesso!');

            }
            
            
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

}
