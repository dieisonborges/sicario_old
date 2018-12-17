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

use App\Http\Controllers\Log;
use App\Http\Controllers\LogController;

class TicketController extends Controller
{
    
    /* ----------------------- LOGS ----------------------*/

    private function log($info){
        //path name
        $filename="TicketController";

        $log = new LogController;
        $log->store($filename, $info);
        return null;     
    }

    /* ----------------------- END LOGS --------------------*/


    private $ticket;

    public function __construct(Ticket $ticket){
        $this->ticket = $ticket;        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!(Gate::denies('read_ticket'))){


            $tickets = Ticket::orderBy('id', 'DESC')
                                ->paginate(40);;

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.index");
            //--------------------------------------------------------------------------------------------

            return view('ticket.index', array('tickets' => $tickets, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
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


    public function busca (Request $request){
        if(!(Gate::denies('read_ticket'))){
            $buscaInput = $request->input('busca');
            $tickets = Ticket::where('titulo', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('descricao', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('protocolo', 'LIKE', '%'.$buscaInput.'%')
                                ->orderBy('id', 'DESC')
                                ->paginate(40); 

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.index.busca=".$buscaInput);
            //--------------------------------------------------------------------------------------------

            return view('ticket.index', array('tickets' => $tickets, 'buscar' => $buscaInput ));
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
    public function create()
    {
        //
        if(!(Gate::denies('create_ticket'))){
            $equipamentos = Equipamento::all(); 
            //Tipos
            $tipos = $this->ticketTipo();

            //Rotulos
            $rotulos = $this->ticketRotulo();

            //Status
            $status = $this->ticketStatus();

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.create");
            //--------------------------------------------------------------------------------------------


            return view('ticket.create', compact('equipamentos', 'tipos', 'rotulos', 'status'));
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
        //
        if(!(Gate::denies('create_ticket'))){
            //Validação
            $this->validate($request,[
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

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.store");
            //--------------------------------------------------------------------------------------------


            if($ticket->save()){
                return redirect('tickets/1/status')->with('success', 'Ticket cadastrado com sucesso!');
            }else{
                return redirect('tickets/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        if(!(Gate::denies('read_ticket'))){
            $ticket = Ticket::find($id);

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
            $this->log("ticket.show.id=".$id);
            //--------------------------------------------------------------------------------------------


            return view('ticket.show', compact('ticket', 'tipos', 'rotulos', 'status', 'data_aberto', 'prontuarios'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
         if(!(Gate::denies('update_ticket'))){            
            $ticket = Ticket::find($id);  

            //Tipos
            $tipos = $this->ticketTipo();

            //Rotulos
            $rotulos = $this->ticketRotulo();

            //Status
            $status = $this->ticketStatus();

            //recuperar todos equipapmentos
            $equipamentos = Equipamento::all(); 

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.edit.id=".$id);
            //--------------------------------------------------------------------------------------------

            return view('ticket.edit', compact('ticket','id', 'tipos', 'rotulos', 'equipamentos', 'status'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(!(Gate::denies('update_ticket'))){
            $ticket = Ticket::find($id);

            //Validação
            $this->validate($request,[
                    'status' => 'required',
                    'rotulo' => 'required',
                    'tipo' => 'required',
                    'titulo' => 'required|string|max:30',
                    'descricao' => 'required|string|min:15',
            ]);


            $ticket->status = $request->get('status');

            $ticket->rotulo = $request->get('rotulo');

            $ticket->tipo = $request->get('tipo');

            if ($request->get('equipamento_id')) {
                $ticket->equipamento_id = $request->get('equipamento_id');
            }

            $ticket->titulo = $request->get('titulo');

            $ticket->descricao = $request->get('descricao');

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.update.id=".$id);
            //--------------------------------------------------------------------------------------------

            if($ticket->save()){
                return redirect('tickets/')->with('success', 'Ticket atualizado com sucesso!');
            }else{
                return redirect('tickets/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(!(Gate::denies('delete_ticket'))){
            $ticket = Ticket::find($id);        
            
            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.destroy.id=".$id);
            //--------------------------------------------------------------------------------------------

            $ticket->delete();
            return redirect()->back()->with('success','Ticket excluído com sucesso!');
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function acao($id)
    {
        //
         if(!(Gate::denies('update_ticket'))){            
            $ticket = Ticket::find($id); 

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.acao.id=".$id);
            //--------------------------------------------------------------------------------------------

            return view('ticket.acao', compact('ticket'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


    public function storeAcao(Request $request)
    {

        //
        if(!(Gate::denies('create_ticket'))){
            //Validação
            $this->validate($request,[
                    'descricao' => 'required|string|min:15',
                    
            ]);
                                 

            $ticket_id = $request->input('ticket_id');

            //usuário
            $user_id = auth()->user()->id;

            $descricao = $request->input('descricao');

            $ticket = Ticket::find($ticket_id);

            $status = $ticket->prontuarioTickets()->attach([[
                'ticket_id' => $ticket_id, 
                'user_id' => $user_id, 
                'descricao' => $descricao,
                'created_at' => date ("Y-m-d H:i:s"),
                'updated_at' => date ("Y-m-d H:i:s")
            ]]); 

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.storeAcao.id=".$ticket_id);
            //--------------------------------------------------------------------------------------------

            if(!$status){
                return redirect('tickets/'.$ticket_id)->with('success', ' Ação adicionada com sucesso!');
            }else{
                return redirect('tickets/'.$ticket_id.'/acao')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function encerrar($id)
    {
        //
         if(!(Gate::denies('update_ticket'))){            
            $ticket = Ticket::find($id); 

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.encerrar.id=".$id);
            //--------------------------------------------------------------------------------------------

            return view('ticket.encerrar', compact('ticket'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


    public function storeEncerrar(Request $request)
    {

        //
        if(!(Gate::denies('create_ticket'))){
            //Validação
            $this->validate($request,[
                    'descricao' => 'required|string|min:15',
                    
            ]);
                                 

            $ticket_id = $request->input('ticket_id');

            //usuário
            $user_id = auth()->user()->id;

            $descricao = $request->input('descricao');

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
            $this->log("ticket.storeEncerrar.id=".$ticket_id);
            //--------------------------------------------------------------------------------------------

            if((!$status)and($ticket->save())){
                return redirect('tickets/'.$ticket_id)->with('success', ' Ticket Encerrado com sucesso!');
            }else{
                return redirect('tickets/'.$ticket_id.'/acao')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


    public function status($status)
    {
        //
        if(!(Gate::denies('read_ticket'))){


            $tickets = Ticket::where('status', $status)
                                ->orderBy('id', 'DESC')
                                ->paginate(40);;

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.status=".$status);
            //--------------------------------------------------------------------------------------------

            return view('ticket.index', array('tickets' => $tickets, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function setors($id){        
        if(!(Gate::denies('read_ticket'))){        
            //Recupera User
            $ticket = $this->ticket->find($id);

            //recuperar setors
            $setors = $ticket->setors()->get();

            //todas permissoes
            $all_setors = Setor::all();

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.setor.id=".$id);
            //--------------------------------------------------------------------------------------------

            return view('ticket.setor', compact('ticket', 'setors', 'all_setors'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }


    public function setorUpdate(Request $request){

        if(!(Gate::denies('update_setor'))){            
                    
            $setor_id = $request->input('setor_id');
            $ticket_id = $request->input('ticket_id'); 

            $ticket  = Ticket::find($ticket_id);

            $status = Setor::find($setor_id)->setorTicket()->attach($ticket->id);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.setorUpdate.id=".$ticket_id);
            //--------------------------------------------------------------------------------------------
          
            if(!$status){
                return redirect('tickets/'.$ticket_id.'/setors')->with('success', 'Setor (Regra) atualizada com sucesso!');
            }else{
                return redirect('tickets/'.$ticket_id.'/setors')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function setorDestroy(Request $request){

        if(!(Gate::denies('delete_setor'))){

            $setor_id = $request->input('setor_id');
            $ticket_id = $request->input('ticket_id');  

            $ticket = Ticket::find($ticket_id); 
            $setor = Setor::find($setor_id);

            $status = $setor ->setorTicket()->detach($ticket->id);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.setorDestroy.id=".$ticket_id);
            //--------------------------------------------------------------------------------------------
            
            if($status){
                return redirect('tickets/'.$ticket_id.'/setors')->with('success', 'Setor (Regra) excluída com sucesso!');
            }else{
                return redirect('tickets/'.$ticket_id.'/setors')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

}
