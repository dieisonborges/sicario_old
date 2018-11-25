<?php

namespace App\Http\Controllers;

use App\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
//use Request;
use Gate;
use App\Ticket;
use App\Equipamento;
use App\Setor; 

class TecnicoController extends Controller
{
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

        $protocolo = $chars[rand (0 , 25)];
        $protocolo .= $chars[rand (0 , 25)];
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

            $tickets = $setor->tickets()->paginate(40);


            return view('tecnico.index', array('setor' => $setor, 'tickets' => $tickets, 'buscar' => null));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    public function busca (Request $request, $setor){
        if(!(Gate::denies('read_'.$setor))){

            $buscaInput = $request->input('busca');

             //usuário
            //$user_id = auth()->user()->id;

            //setor
            $setors = Setor::where('name', $setor)->limit(1)->get();

            foreach ($setors as $setor ) {
                $temp_setor = $setor;
            }

            $setor = $temp_setor;

            $tickets = $setor->tickets()
                                ->where(function($query) use ($buscaInput) {
                                    $query->where('titulo','LIKE' , '%'.$buscaInput.'%')
                                    ->orwhere('descricao', 'LIKE', '%'.$buscaInput.'%')
                                    ->orwhere('protocolo', 'LIKE', '%'.$buscaInput.'%');
                                })
                                ->paginate(40);


            return view('tecnico.index', array('tickets' => $tickets, 'buscar' => $buscaInput, 'setor' => $setor ));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    public function status($setor, $status)
    {
        //
        if(!(Gate::denies('read_'.$setor))){


            //$tickets = Ticket::where('status', $status)->paginate(40);

            //setor
            $setors = Setor::where('name', $setor)->limit(1)->get();

            foreach ($setors as $setor ) {
                $temp_setor = $setor;
            }

            $setor = $temp_setor;

            $tickets = $setor->tickets()                                
                                ->where('status', $status)
                                ->paginate(40);
            

            return view('tecnico.index', array('tickets' => $tickets, 'buscar' => null, 'setor' => $setor));
        }


        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    public function buscaStatus($setor, $status)
    {
        //
        if(!(Gate::denies('read_'.$setor))){

            $buscaInput = $request->input('busca');


            //$tickets = Ticket::where('status', $status)->paginate(40);

            //setor
            $setors = Setor::where('name', $setor)->limit(1)->get();

            foreach ($setors as $setor ) {
                $temp_setor = $setor;
            }

            $setor = $temp_setor;

            $tickets = $setor->tickets()
                                ->where(function($query) use ($buscaInput) {
                                    $query->where('titulo','LIKE' , '%'.$buscaInput.'%')
                                    ->orwhere('descricao', 'LIKE', '%'.$buscaInput.'%')
                                    ->orwhere('protocolo', 'LIKE', '%'.$buscaInput.'%');
                                })
                                ->where('status', $status)
                                ->paginate(40);
            

            return view('tecnico.index', array('tickets' => $tickets, 'buscar' => $buscaInput, 'setor' => $setor ));
        }

        
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    public function show($setor, $id)
    {    
        //
        if(!(Gate::denies('read_'.$setor))){
            $ticket = Ticket::find($id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->get();
            foreach ($setors_security as $setor_sec ) {
                $setors_security = $setor_sec;
            }

            if(!(isset($setors_security->id))){
                return redirect('home')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            //Tipos
            $tipos = $this->ticketTipo();

            //Rotulos
            $rotulos = $this->ticketRotulo();

            //Status
            $status = $this->ticketStatus();

            //Verifica o ticket em dias
            $data_aberto = $this->calcDatas(date('Y-m-d', strtotime($ticket->created_at)), date ("Y-m-d"));

            $prontuarios = $ticket->prontuarioTicketsShow()->get();


            return view('tecnico.show', compact('ticket', 'tipos', 'rotulos', 'status', 'data_aberto', 'prontuarios', 'setor'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }

    public function edit($setor, $id)
    {
        //
        if(!(Gate::denies('update_'.$setor))){           
            $ticket = Ticket::find($id);  

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->get();
            foreach ($setors_security as $setor_sec ) {
                $setors_security = $setor_sec;
            }

            if(!(isset($setors_security->id))){
                return redirect('home')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            //Tipos
            $tipos = $this->ticketTipo();

            //Rotulos
            $rotulos = $this->ticketRotulo();

            //Status
            $status = $this->ticketStatus();

            //recuperar todos equipapmentos
            $equipamentos = Equipamento::all(); 

            return view('tecnico.edit', compact('ticket','id', 'tipos', 'rotulos', 'equipamentos', 'status', 'setor'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    public function update(Request $request, $setor, $id)
    {
        //
        if(!(Gate::denies('update_'.$setor))){ 

            $ticket = Ticket::find($id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->get();
            foreach ($setors_security as $setor_sec ) {
                $setors_security = $setor_sec;
            }

            if(!(isset($setors_security->id))){
                return redirect('home')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

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

            if($ticket->save()){
                return redirect('tecnicos/'.$setor.'/tickets')->with('success', 'Ticket atualizado com sucesso!');
            }else{
                return redirect('tecnicos/'.$setor.'/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }


    public function setors($setor, $id){

        $my_setor = $setor;

        if(!(Gate::denies('read_'.$setor))){  


            $ticket = $this->ticket->find($id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->get();
            foreach ($setors_security as $setor_sec ) {
                $setors_security = $setor_sec;
            }

            if(!(isset($setors_security->id))){
                return redirect('home')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/


            //recuperar setors
            $setors = $ticket->setors()->get();

            //todos setores
            $all_setors = Setor::all();


            return view('tecnico.setor', compact('ticket', 'setors', 'all_setors', 'my_setor'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }

    public function setorUpdate(Request $request){
            $my_setor = $request->input('my_setor'); 

        if(!(Gate::denies('update_'.$my_setor))){              
                    
            $setor_id = $request->input('setor_id');
            $ticket_id = $request->input('ticket_id');

            $ticket  = Ticket::find($ticket_id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $my_setor)->get();
            foreach ($setors_security as $setor_sec ) {
                $setors_security = $setor_sec;
            }

            if(!(isset($setors_security->id))){
                return redirect('home')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            $status = Setor::find($setor_id)->setorTicket()->attach($ticket->id);
          
            if(!$status){
                return redirect('tecnicos/'.$my_setor."/".$ticket_id.'/setors')->with('success', 'Setor (Regra) atualizada com sucesso!');
            }else{
                return redirect('tecnicos/'.$my_setor."/".$ticket_id.'/setors')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }


    public function setorDestroy(Request $request){

        $my_setor = $request->input('my_setor'); 

        if(!(Gate::denies('delete_'.$my_setor))){
            $setor_id = $request->input('setor_id');
            $ticket_id = $request->input('ticket_id');  

            $ticket = Ticket::find($ticket_id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $my_setor)->get();
            foreach ($setors_security as $setor_sec ) {
                $setors_security = $setor_sec;
            }

            if(!(isset($setors_security->id))){
                return redirect('home')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            $setor = Setor::find($setor_id);

            $status = $setor ->setorTicket()->detach($ticket->id);

            
            if($status){
                return redirect('tecnicos/'.$my_setor."/".$ticket_id.'/setors')->with('success', 'Setor (Regra) atualizada com sucesso!');
            }else{
                return redirect('tecnicos/'.$my_setor."/".$ticket_id.'/setors')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    public function acao($setor, $id)
    {
        //
        if(!(Gate::denies('update_'.$setor))){           
            $ticket = Ticket::find($id); 

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->get();
            foreach ($setors_security as $setor_sec ) {
                $setors_security = $setor_sec;
            }

            if(!(isset($setors_security->id))){
                return redirect('home')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            return view('tecnico.acao', array('ticket' => $ticket, 'setor' => $setor));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    public function storeAcao(Request $request)
    {

        
        $setor = $request->input('setor');

        //
        if(!(Gate::denies('update_'.$setor))){ 
            //Validação
            $this->validate($request,[
                    'descricao' => 'required|string|min:15',
                    
            ]);
                                 

            $ticket_id = $request->input('ticket_id');

            //usuário
            $user_id = auth()->user()->id;

            $descricao = $request->input('descricao');

            $ticket = Ticket::find($ticket_id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->get();
            foreach ($setors_security as $setor_sec ) {
                $setors_security = $setor_sec;
            }

            if(!(isset($setors_security->id))){
                return redirect('home')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/



            $status = $ticket->prontuarioTickets()->attach([[
                'ticket_id' => $ticket_id, 
                'user_id' => $user_id, 
                'descricao' => $descricao,
                'created_at' => date ("Y-m-d h:i:s"),
                'updated_at' => date ("Y-m-d h:i:s")
            ]]); 

            if(!$status){
                return redirect('tecnicos/'.$setor.'/'.$ticket_id.'/show')->with('success', ' Ação adicionada com sucesso!');
            }else{
                return redirect('tecnicos/'.$setor.'/'.$ticket_id.'/acao')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    public function encerrar($setor, $id)
    {
        //
        if(!(Gate::denies('update_'.$setor))){           
            $ticket = Ticket::find($id); 

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->get();
            foreach ($setors_security as $setor_sec ) {
                $setors_security = $setor_sec;
            }

            if(!(isset($setors_security->id))){
                return redirect('home')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            return view('tecnico.encerrar', compact('ticket', 'setor'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }


    public function storeEncerrar(Request $request)
    {

        $setor = $request->input('setor');

        //
        if(!(Gate::denies('update_'.$setor))){  
            //Validação
            $this->validate($request,[
                    'descricao' => 'required|string|min:15',
                    
            ]);
                                 

            $ticket_id = $request->input('ticket_id');

            //usuário
            $user_id = auth()->user()->id;

            $descricao = $request->input('descricao');

            $ticket = Ticket::find($ticket_id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->get();
            foreach ($setors_security as $setor_sec ) {
                $setors_security = $setor_sec;
            }

            if(!(isset($setors_security->id))){
                return redirect('home')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            $status = $ticket->prontuarioTickets()->attach([[
                'ticket_id' => $ticket_id, 
                'user_id' => $user_id, 
                'descricao' => $descricao,
                'created_at' => date ("Y-m-d h:i:s"),
                'updated_at' => date ("Y-m-d h:i:s")
            ]]); 

            /* ----------------- Encerra -------------*/
            
            $ticket->status = 0;

            /* ---------------------- Encerra FIM ----------*/

            if((!$status)and($ticket->save())){
                return redirect('tecnicos/'.$setor.'/'.$ticket_id.'/show')->with('success', ' Ticket Encerrado com sucesso!');
            }else{
                return redirect('tecnicos/'.$setor.'/'.$ticket_id.'/acao')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }




}
