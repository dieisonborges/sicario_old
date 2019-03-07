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
use App\Http\Controllers\Log;
use App\Http\Controllers\LogController;

class TecnicoController extends Controller
{
    /* ----------------------- LOGS ----------------------*/

    private function log($info){
        //path name
        $filename="TecnicoController";

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

            $tickets = $setor->tickets()
                                ->orderBy('id', 'DESC')
                                ->paginate(40);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.index");
            //--------------------------------------------------------------------------------------------

            return view('tecnico.index', array('setor' => $setor, 'tickets' => $tickets, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
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
                                ->orderBy('id', 'DESC')
                                ->paginate(40);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.busca=".$buscaInput);
            //--------------------------------------------------------------------------------------------

            return view('tecnico.index', array('tickets' => $tickets, 'buscar' => $buscaInput, 'setor' => $setor ));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function status($setor, $status)
    {
        //
        if(!(Gate::denies('read_'.$setor))){

            //setor
            $setors = Setor::where('name', $setor)->limit(1)->get();

            foreach ($setors as $setor ) {
                $temp_setor = $setor;
            }

            $setor = $temp_setor;

            $tickets = $setor->tickets()                                
                                ->where('status', $status)
                                ->orderBy('id', 'DESC')
                                ->paginate(40);
            
            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.index.status=".$status);
            //--------------------------------------------------------------------------------------------

            return view('tecnico.index', array('tickets' => $tickets, 'buscar' => null, 'setor' => $setor));
        }


        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function buscaStatus($setor, $status)
    {
        //
        if(!(Gate::denies('read_'.$setor))){

            $buscaInput = $request->input('busca');

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
                                ->orderBy('id', 'DESC')
                                ->paginate(40);
            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.status=".$status."busca=".$buscaInput);
            //--------------------------------------------------------------------------------------------

            return view('tecnico.index', array('tickets' => $tickets, 'buscar' => $buscaInput, 'setor' => $setor ));
        }

        
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function buscaStatusIdEquipamento($setor, $equipamento_id, $status)
    {
        
        //
        if(!(Gate::denies('read_'.$setor))){

            //setor
            $setors = Setor::where('name', $setor)->limit(1)->get();

            foreach ($setors as $setor ) {
                $temp_setor = $setor;
            }

            $setor = $temp_setor;

            $tickets = $setor->tickets()
                                ->where('equipamento_id', $equipamento_id)
                                ->where('status', $status)
                                ->orderBy('id', 'DESC')
                                ->paginate(40);

            $equipamento = Equipamento::find($equipamento_id);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.status.id=".$status."equipamento_id=".$equipamento_id);
            //--------------------------------------------------------------------------------------------

            return view('tecnico.index', array('tickets' => $tickets, 'buscar' => $equipamento->nome, 'setor' => $setor ));
        }

        
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function show($setor, $id)
    {    
        //
        if(!(Gate::denies('read_'.$setor))){
            $ticket = Ticket::find($id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
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

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.show.ticket=".$ticket->id);
            //--------------------------------------------------------------------------------------------


            return view('tecnico.show', compact('ticket', 'tipos', 'rotulos', 'status', 'data_aberto', 'prontuarios', 'setor'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function edit($setor, $id)
    {
        //
        if(!(Gate::denies('update_'.$setor))){           
            $ticket = Ticket::find($id);  

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
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

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.edit.id:".$id);
            //--------------------------------------------------------------------------------------------

            if($ticket->status==0){
                return redirect('erro')->with('permission_error', '403');
            }else{
                return view('tecnico.edit', compact('ticket','id', 'tipos', 'rotulos', 'equipamentos', 'status', 'setor'));
            }

            
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function update(Request $request, $setor, $id)
    {
        //
        if(!(Gate::denies('update_'.$setor))){ 

            $ticket = Ticket::find($id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            //Validação
            $this->validate($request,[
                    'status' => 'required',
                    'rotulo' => 'required',
                    'tipo' => 'required',
                    'titulo' => 'required|string|max:30',
                    /*'descricao' => 'required|string|min:15',*/
            ]);


            $ticket->status = $request->get('status');

            $ticket->rotulo = $request->get('rotulo');

            $ticket->tipo = $request->get('tipo');

            if ($request->get('equipamento_id')) {
                $ticket->equipamento_id = $request->get('equipamento_id');
            }

            $ticket->titulo = $request->get('titulo');

            //$ticket->descricao = $request->get('descricao');

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.edit.update.ticket".$id."-".$ticket);
            //--------------------------------------------------------------------------------------------

            if($ticket->save()){
                return redirect('tecnicos/'.$setor.'/tickets')->with('success', 'Ticket atualizado com sucesso!');
            }else{
                return redirect('tecnicos/'.$setor.'/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


    public function setors($setor, $id){

        $my_setor = $setor;

        if(!(Gate::denies('read_'.$setor))){  


            $ticket = $this->ticket->find($id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/


            //recuperar setors
            $setors = $ticket->setors()->get();

            //todos setores
            $all_setors = Setor::all();

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.setor.ticket:".$id);
            //--------------------------------------------------------------------------------------------


            return view('tecnico.setor', compact('ticket', 'setors', 'all_setors', 'my_setor'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
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
            $setors_security = $ticket->setors()->where('name', $my_setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            $status = Setor::find($setor_id)->setorTicket()->attach($ticket->id);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.setorUpdate.setor_id:".$setor_id."ticket_id:".$ticket_id);
            //--------------------------------------------------------------------------------------------
          
            if(!$status){
                return redirect('tecnicos/'.$my_setor."/".$ticket_id.'/setors')->with('success', 'Setor (Regra) atualizada com sucesso!');
            }else{
                return redirect('tecnicos/'.$my_setor."/".$ticket_id.'/setors')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
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
            $setors_security = $ticket->setors()->where('name', $my_setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            $setor = Setor::find($setor_id);

            $status = $setor ->setorTicket()->detach($ticket->id);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.setorDestroy.setor:".$setor->name);
            //--------------------------------------------------------------------------------------------

            
            if($status){
                return redirect('tecnicos/'.$my_setor."/".$ticket_id.'/setors')->with('success', 'Setor (Regra) atualizada com sucesso!');
            }else{
                return redirect('tecnicos/'.$my_setor."/".$ticket_id.'/setors')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function acao($setor, $id)
    {
        //
        if(!(Gate::denies('update_'.$setor))){           
            $ticket = Ticket::find($id); 

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.acao.setor:".$ticket->id);
            //--------------------------------------------------------------------------------------------

            return view('tecnico.acao', array('ticket' => $ticket, 'setor' => $setor));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
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

            $descricao .= '<br><span class="btn btn-primary btn-xs">Ação</span>';

            $ticket = Ticket::find($ticket_id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/



            $status = $ticket->prontuarioTickets()->attach([[
                'ticket_id' => $ticket_id, 
                'user_id' => $user_id, 
                'descricao' => $descricao,
                'created_at' => date ("Y-m-d H:i:s"),
                'updated_at' => date ("Y-m-d H:i:s")
            ]]); 

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.storeAcao:".$ticket_id);
            //--------------------------------------------------------------------------------------------

            if(!$status){
                return redirect('tecnicos/'.$setor.'/'.$ticket_id.'/show')->with('success', ' Ação adicionada com sucesso!');
            }else{
                return redirect('tecnicos/'.$setor.'/'.$ticket_id.'/acao')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function encerrar($setor, $id)
    {
        //
        if(!(Gate::denies('update_'.$setor))){           
            $ticket = Ticket::find($id); 

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.encerrar:".$id);
            //--------------------------------------------------------------------------------------------

            return view('tecnico.encerrar', compact('ticket', 'setor'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
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

            $descricao .= '<br><br><span class="btn btn-danger btn-xs">Fechado em: '.date("d/m/Y H:i:s").'</span>';

            $ticket = Ticket::find($ticket_id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

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
            $this->log("tecnico.storeEncerrar:".$ticket_id);
            //--------------------------------------------------------------------------------------------

            if((!$status)and($ticket->save())){
                return redirect('tecnicos/'.$setor.'/'.$ticket_id.'/show')->with('success', ' Ticket Encerrado com sucesso!');
            }else{
                return redirect('tecnicos/'.$setor.'/'.$ticket_id.'/acao')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function reabrir($setor, $id)
    {
        //
        if(!(Gate::denies('update_'.$setor))){           
            $ticket = Ticket::find($id); 

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.encerrar:".$id);
            //--------------------------------------------------------------------------------------------

            return view('tecnico.reabrir', compact('ticket', 'setor'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


    public function storeReabrir(Request $request)
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

            $descricao .= '<br><br><span class="btn btn-success btn-xs">Reaberto em: '.date("d/m/Y H:i:s").'</span>';

            $ticket = Ticket::find($ticket_id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            $status = $ticket->prontuarioTickets()->attach([[
                'ticket_id' => $ticket_id, 
                'user_id' => $user_id, 
                'descricao' => $descricao,
                'created_at' => date ("Y-m-d H:i:s"),
                'updated_at' => date ("Y-m-d H:i:s")
            ]]); 

            /* ----------------- Reabre -------------*/
            
            $ticket->status = 1;

            /* ---------------------- Encerra FIM ----------*/

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.storeReabrir:".$ticket_id);
            //--------------------------------------------------------------------------------------------

            if((!$status)and($ticket->save())){
                return redirect('tecnicos/'.$setor.'/'.$ticket_id.'/show')->with('success', ' Ticket Reaberto com sucesso!');
            }else{
                return redirect('tecnicos/'.$setor.'/'.$ticket_id.'/acao')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


    /* ------------------------------ DASHBOARD --------------------------*/
    public function dashboard($setor)
    {
        
        //
        if(!(Gate::denies('read_'.$setor))){
            /* ======================== FILTRO SETOR ======================== */
            $setor = Setor::where('name', $setor)->first();
            /* ======================== END FILTRO SETOR ==================== */

            /* .................... EQUIPE ...................*/
            $equipe = $setor->users()->get();
            $equipe_qtd = $setor->users()->count();     

            /* .................... END QTD Tickets Abertos ................... */

            /* .................... QTD Tickets Abertos ................... */
            $qtd_tick_aber = $setor->tickets()                                
                                ->where('status', 1)
                                ->count();
            /* .................... END QTD Tickets Abertos ................... */

            /* .................... QTD Tickets FECHADOS ................... */
            $qtd_tick_fech = $setor->tickets()                                
                                ->where('status', 0)
                                ->count();
            /* .................... END QTD Tickets FECHADOS ................... */

            /* .................... Tickets Abertos ................... */
            $tickets = $setor->tickets()                                
                                ->where('status', 1)
                                ->get();
            /* .................... END QTD Tickets Abertos ................... */

            /* .................... Últimos Livros ................... */

            $livros = $setor->livros()
                            ->orderBy('id','DESC')
                            ->limit(4)
                            ->get();

            /* .................... END Últimos Livros ................... */

            /* WEEK */
            $week = $this->weekBr();
            /* END WEEK */

            /* .................... QTD não alocados ................... */

            $tickets_aloc = Ticket::where('status', '1')->get();

            $cont_aloc = 0;

            foreach ($tickets_aloc as $ticket_aloc) {
                $flagTicket=0;
                $setors_aloc = $ticket_aloc->setors()->get();
                foreach ($setors_aloc as $setor_aloc) {
                    if(isset($setor_aloc->id)){
                        $flagTicket=1;
                    }
                }
                if($flagTicket==0){
                    $cont_aloc+=1;
                }
            }



            /* .................... END QTD não alocados ................... */

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.dashboard");
            //--------------------------------------------------------------------------------------------



            return view('tecnico.dashboard', compact(
                            'qtd_tick_fech', 
                            'qtd_tick_aber', 
                            'setor',
                            'equipe',
                            'equipe_qtd',
                            'tickets',
                            'livros',
                            'week',
                            'cont_aloc'
                        ));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }
    /* ----------------------------- END DASHBOARD ---------------------*/

    public function alocar($setor)
    {
        
        //
        if(!(Gate::denies('read_'.$setor))){

            $tickets = Ticket::where('status', '1')->paginate();

            $setor = Setor::where('name', $setor)->first();

            foreach ($tickets as $ticket) {
                $flagTicket[$ticket->id]=0;
                $setors = $ticket->setors()->get();
                foreach ($setors as $setor_get) {
                    if(isset($setor_get->id)){
                        $flagTicket[$ticket->id]=1;
                    }
                }
            }

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.alocar");
            //--------------------------------------------------------------------------------------------

            return view('tecnico.alocar', compact(
                            'tickets',
                            'setor',
                            'flagTicket'
                        ));

        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function alocarSetors($setor, $id){

        $my_setor = $setor;

        if(!(Gate::denies('read_'.$setor))){  


            $ticket = $this->ticket->find($id);

            //recuperar setors
            $setors = $ticket->setors()->get();

            //todos setores
            $all_setors = Setor::all();

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.alocarSetors:".$id);
            //--------------------------------------------------------------------------------------------


            return view('tecnico.alocarsetor', compact('ticket', 'setors', 'all_setors', 'my_setor'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function alocarSetorUpdate(Request $request){

        $my_setor = $request->input('my_setor');

        if(!(Gate::denies('update_'.$my_setor))){              
                    
            $setor_id = $request->input('setor_id');
            $ticket_id = $request->input('ticket_id');

            $ticket  = Ticket::find($ticket_id);

            $status = Setor::find($setor_id)->setorTicket()->attach($ticket->id);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.alocarSetorsUpdate:".$setor_id."Ticket".$ticket_id);
            //--------------------------------------------------------------------------------------------
          
            if(!$status){
                return redirect('tecnicos/'.$my_setor.'/dashboard')->with('success', 'Setor (Regra) atualizada com sucesso!');
            }else{
                return redirect('tecnicos/'.$my_setor.'/dashboard')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function buscaData (Request $request, $setor){
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
                                ->orderBy('id', 'DESC')
                                ->paginate(40);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.busca=".$buscaInput);
            //--------------------------------------------------------------------------------------------

            return view('tecnico.data', array('tickets' => $tickets, 'buscar' => $buscaInput, 'setor' => $setor ));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


}
