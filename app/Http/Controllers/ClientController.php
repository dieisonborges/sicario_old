<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
//use Request;
use Gate;
use App\Ticket;
use App\Equipamento;
use App\Setor; 
use DB;

use App\Http\Controllers\Log;
use App\Http\Controllers\LogController;

class ClientController extends Controller
{
    
    /* ----------------------- LOGS ----------------------*/

    private function log($info){
        //path name
        $filename="ClientController";

        $log = new LogController;
        $log->store($filename, $info);
        return null;     
    }

    /* ----------------------- END LOGS --------------------*/

    //
    private $ticket;

    public function __construct(Ticket $ticket){
        $this->ticket = $ticket;        
    }

    private function ticketTipo()
    {
        //
        $tipo = array(
                0  => "Técnico",
                1  => "Administrativo",                
            );

        return $tipo;
    }

    private function ticketRotulo()
    {
        //
        $rotulo = array(
                0   =>  "Crítico - Emergência (resolver imediatamente)",
                1   =>  "Alto - Urgência (resolver o mais rápido possível)",
                2   =>  "Médio - Intermediária (avaliar situação)",
                3   =>  "Baixo - Rotineiro ou Planejado",
                4   =>  "Nenhum",
            );

        return $rotulo;
    }

    private function ticketStatus()
    {
        //
        $status = array(
                0  => "Fechado",
                1  => "Aberto",                
            );

        return $status;
    }

    private function protocolo()
    {
        
        $chars = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';

        $protocolo = $chars[rand (0 , 24)];
        $protocolo .= $chars[rand (0 , 24)];
        $protocolo .= rand (0 , 9);
        $protocolo .= rand (0 , 9);
        $protocolo .= rand (0 , 9);
        $protocolo .= rand (0 , 9);


        return date("Y").$protocolo;
    }

    private function calcDatas($data_ini, $data_fim){
        //Compara duas datas e retorna a diferença entre dias

        //$data_ini = "2013-08-01";
        //$data_fim = "2013-08-16";

        $diferenca = strtotime($data_fim) - strtotime($data_ini);

        //Calcula a diferença em dias
        $dias = floor($diferenca / (60 * 60 * 24));

        return $dias;
    }

    public function index()
    {
        //
        if(auth()->user()->id){

        	//usuário
            $user_id = auth()->user()->id;

            $tickets = Ticket::where('user_id', $user_id)->paginate(40);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("client.index");
            //--------------------------------------------------------------------------------------------

            return view('client.index', array('tickets' => $tickets, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function busca (Request $request){
        if(auth()->user()->id){

        	//usuário
            $user_id = auth()->user()->id;

            $buscaInput = $request->input('busca');           

			// ...
			$tickets = Ticket::where(function ($query) use ($buscaInput) {
			    $query->where('titulo','LIKE' , '%'.$buscaInput.'%')
			        ->orwhere('descricao', 'LIKE', '%'.$buscaInput.'%')
                    ->orwhere('protocolo', 'LIKE', '%'.$buscaInput.'%');
			})->Where(function($query) use ($user_id) {
			    $query->where('user_id', $user_id);	
			})->paginate(40);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("client.index.busca=".$buscaInput);
            //--------------------------------------------------------------------------------------------

			            				   
            return view('client.index', array('tickets' => $tickets, 'buscar' => $buscaInput ));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

        public function status($status)
    {
        //
        if(auth()->user()->id){

        	//usuário
            $user_id = auth()->user()->id;

            $tickets = Ticket::where('user_id', $user_id)
            				 ->where('status', $status)
            				 ->paginate(40);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("client.index.status=".$status);
            //--------------------------------------------------------------------------------------------

            return view('client.index', array('tickets' => $tickets, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function create()
    {
        //
        if(auth()->user()->id){
            $equipamentos = Equipamento::all(); 
            //Tipos
            $tipos = $this->ticketTipo();

            //Rotulos
            $rotulos = $this->ticketRotulo();

            //Status
            $status = $this->ticketStatus();

            $setores = Setor::all();

            //LOG ----------------------------------------------------------------------------------------
            $this->log("client.create");
            //--------------------------------------------------------------------------------------------


            return view('client.create', compact('equipamentos', 'tipos', 'rotulos', 'status', 'setores'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        } 


    }

    public function store(Request $request)
    {
        //
        if(auth()->user()->id){
            //Validação
            $this->validate($request,[
                    'setor' => 'required',
                    'rotulo' => 'required',
                    'tipo' => 'required',
                    'titulo' => 'required|string|max:30',
                    'descricao' => 'required|string|min:15',
                    
            ]);

            $ticket = new Ticket();
            $ticket->status = 1;

            $ticket->rotulo = $request->input('rotulo');

            if ($request->input('equipamento_id')) {
                $ticket->equipamento_id = $request->input('equipamento_id');
            }

            $ticket->tipo = $request->input('tipo');

            $ticket->titulo = $request->input('titulo');

            $ticket->descricao = $request->input('descricao');
            

            //usuário
            $ticket->user_id = auth()->user()->id;

            //protocolo humano
            $ticket->protocolo = $this->protocolo();


            if($ticket->save()){

                $setores = $request->input('setor');

                $ticket_id = DB::getPdo()->lastInsertId();
                //Vincula tecnicos ao livro
                foreach ($setores as $setor) {
                    Ticket::find($ticket_id)->setors()->attach($setor);
            }

            //LOG ----------------------------------------------------------------------------------------
            $this->log("client.store");
            //-------------------------------------------------------------------------------------------- 

                return redirect('clients/1/status')->with('success', 'Ticket cadastrado com sucesso!');
            }else{
                return redirect('clients/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function show($id)
    {
        //
        if(auth()->user()->id){

        	//usuário
            $user_id = auth()->user()->id;

            $ticket = Ticket::where('id', $id)->where('user_id', $user_id)->limit(1)->first();

            //Verifica permissão de acesso por usuário
            //Ao ticket
            if(!isset($ticket)){
            	return redirect('erro')->with('permission_error', '403');
            }

            //Tipos
            $tipos = $this->ticketTipo();

            //Rotulos
            $rotulos = $this->ticketRotulo();

            //Status
            $status = $this->ticketStatus();

            //Verifica o ticket em dias
            $data_aberto = $this->calcDatas(date('Y-m-d', strtotime($ticket->created_at)), date ("Y-m-d"));

            $prontuarios = $ticket->prontuarioTicketsShow()->get();

            //LOG ----------------------------------------------------------------------------------------
            $this->log("client.show.id=".$id);
            //--------------------------------------------------------------------------------------------


            return view('client.show', compact('ticket', 'tipos', 'rotulos', 'status', 'data_aberto', 'prontuarios'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function acao($id)
    {
        //
         if(auth()->user()->id){            
            $ticket = Ticket::find($id);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("client.acao=".$id);
            //--------------------------------------------------------------------------------------------

            return view('client.acao', compact('ticket'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


    public function storeAcao(Request $request)
    {

        //
        if(auth()->user()->id){
            //Validação
            $this->validate($request,[
                    'descricao' => 'required|string|min:15',
                    
            ]);
                                 

            $ticket_id = $request->input('ticket_id');

            //usuário
            $user_id = auth()->user()->id;

            $descricao = $request->input('descricao');

            $descricao .= '<br><span class="btn btn-primary btn-xs">Ação</span>';

            $ticket = Ticket::find($ticket_id);

            $status = $ticket->prontuarioTickets()->attach([[
                'ticket_id' => $ticket_id, 
                'user_id' => $user_id, 
                'descricao' => $descricao,
                'created_at' => date ("Y-m-d H:i:s"),
                'updated_at' => date ("Y-m-d H:i:s")
            ]]); 

            //LOG ----------------------------------------------------------------------------------------
            $this->log("client.store.acao.id=".$ticket_id);
            //--------------------------------------------------------------------------------------------

            if(!$status){
                return redirect('clients/'.$ticket_id)->with('success', ' Ação adicionada com sucesso!');
            }else{
                return redirect('clients/'.$ticket_id.'/acao')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function encerrar($id)
    {
        //
         if(auth()->user()->id){            
            $ticket = Ticket::find($id); 

            //LOG ----------------------------------------------------------------------------------------
            $this->log("client.encerrar.id=".$id);
            //--------------------------------------------------------------------------------------------

            return view('client.encerrar', compact('ticket'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


    public function storeEncerrar(Request $request)
    {

        //
        if(auth()->user()->id){
            //Validação
            $this->validate($request,[
                    'descricao' => 'required|string|min:15',                    
            ]);                                 

            $ticket_id = $request->input('ticket_id');

            //usuário
            $user_id = auth()->user()->id;

            $descricao = $request->input('descricao');

            $descricao .= '<br><br><span class="btn btn-danger btn-xs">Fechado em: '.date("d/m/Y H:i:s").'</span>';

            $ticket = Ticket::find($ticket_id);

            $status = $ticket->prontuarioTickets()->attach([[
                'ticket_id' => $ticket_id, 
                'user_id' => $user_id, 
                'descricao' => $descricao,
                'created_at' => date ("Y-m-d H:i:s"),
                'updated_at' => date ("Y-m-d H:i:s")
            ]]); 

            /* ----------------- Encerra -------------*/
            
            $ticket->status = 0;

            /* ---------------------- Encerra FIM ----------*/

            //LOG ----------------------------------------------------------------------------------------
            $this->log("client.store.encerrar.id=".$ticket_id);
            //--------------------------------------------------------------------------------------------

            if((!$status)and($ticket->save())){
                return redirect('clients/'.$ticket_id)->with('success', ' Ticket Encerrado com sucesso!');
            }else{
                return redirect('clients/'.$ticket_id.'/acao')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

}
