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
use App\Tutorial;
use App\Livro;
use App\Upload;
use DB;

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

    private function removePreposicoes($string){
        $expressao = strip_tags ($string);
        // Retira preposições da expressão. É importante que haja um espaço antes e depois de cada expressão
         
        $palavrasSemPreposicao = str_ireplace ( array (
        " de ",
        " da ",
        " do ",
        " na ",
        " no ",
        " em ",
        " a ",
        " o ",
        " e ",
        " as ",
        " os ",
        " um ",
        " uma ",
        " uns ",
        " umas ",
        " por ",
        " para ",
        " meu ",
        " minha ",
        " seu ",
        " sua ",
        " não ",
        " sim ",
        " muito ",
        " pouco ",
        " bem ",
        " mau ",
        " mal ",
        " este ",
        " estes ",
        " esta ",
        " estas ",
        ), " ", $expressao ); 
        return $palavrasSemPreposicao; //Retorna array com palavras sem preposições ou artigos
    }


    private function storeAcaoAuto($setor, $descricao, $ticket_id, $tipo_acao, $tipo_acao_cor)
    {

        //usuário
        $user_id = auth()->user()->id;

        $descricao .= '<br><span class="btn btn-'.$tipo_acao_cor.' btn-xs">'.$tipo_acao.'</span>';

        $ticket = Ticket::find($ticket_id);

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
            return true;
        }else{
            return false;
        }
        
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
            $setor = Setor::where('name', $setor)->first();
           

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

            $uploads = $ticket->uploads()->get();

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

            /* ----------- Tutoriais parecidos ------------ */           

            //filtro setor
            $setor = Setor::where('name', $setor)->first();

            $titulo = $ticket->titulo;
            //$titulo .= $ticket->descricao;

            //Remove Preposições
            $titulo = $this->removePreposicoes($titulo);

            $titulo_exps = explode(' ', $titulo);           

            $titulo_exps = $titulo;

            /*
            $pages = Page->where(function($query) use($word){

            foreach($searchWords as $word){
                $query->orWhere('content', 'LIKE', '%'.$word.'%');
            }

            })->get();

            */

            $tutorials = $setor->tutorials()
                                ->where(function($query) use($titulo_exps){
                    if(is_array($titulo_exps)){
                        
                        $query->orWhere('titulo', 'LIKE', '%'.array($titulo_exp).'%');
                        $query->orWhere('palavras_chave', 'LIKE', '%'.array($titulo_exp).'%');
                        $query->orWhere('conteudo', 'LIKE', '%'.array($titulo_exp).'%');
                        
                    }else{
                        $query->orWhere('titulo', 'LIKE', '%'.$titulo_exps.'%');
                        $query->orWhere('palavras_chave', 'LIKE', '%'.$titulo_exps.'%');
                        $query->orWhere('conteudo', 'LIKE', '%'.$titulo_exps.'%');
                    }
                })->orderBy('id', 'DESC')->limit('5')->get();


            /* ----------- FIM Tutoriais parecidos ------------ */



            return view('tecnico.show', compact('ticket', 'tipos', 'rotulos', 'status', 'data_aberto', 'prontuarios', 'setor', 'tutorials', 'uploads'));
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

            //Titulo anterior
            $ticket_anterior = Ticket::find($id);

            /* ------------------------------ Security --------------------------------*/
            //verifica se o setor tem permissão ao ticket
            $setors_security = $ticket->setors()->where('name', $setor)->first();

            if(!(isset($setors_security->id))){
                return redirect('erro')->with('permission_error', '403');
            }
            /* ------------------------------ END Security --------------------------------*/

            //Validação
            $this->validate($request,[
                    'rotulo' => 'required',
                    'tipo' => 'required',
                    'titulo' => 'required|string|max:80',
                    'descricao' => 'required|string|min:15',
            ]);

            $ticket->rotulo = $request->get('rotulo');            

            $ticket->tipo = $request->get('tipo');

            if ($request->get('equipamento_id')) {
                $ticket->equipamento_id = $request->get('equipamento_id');
            }

            $ticket->titulo = $request->get('titulo');

            $ticket->descricao = $request->get('descricao');

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.edit.update.ticket".$id."-".$ticket);
            //--------------------------------------------------------------------------------------------

            if($ticket->save()){

                /* -----------Salva mudanças na acao----------- */

                

                $ticketRotulo = $this->ticketRotulo();

                $descricao_acao  = "Rótulo alterado de: <i style='color:red;'>";
                $descricao_acao .= $ticketRotulo[$ticket_anterior->rotulo];
                $descricao_acao .= "</i>";
                $descricao_acao .= " Para: <i style='color:blue;'>";
                $descricao_acao .= $ticketRotulo[$request->get('rotulo')];
                $descricao_acao .= "</i>";

                $descricao_acao .= "<br>";

                $ticketTipo = $this->ticketTipo();

                $descricao_acao .= "Tipo alterado de: <i style='color:red;'>";
                $descricao_acao .= $ticketTipo[$ticket_anterior->tipo];
                $descricao_acao .= "</i>";
                $descricao_acao .= " Para: <i style='color:blue;'>";
                $descricao_acao .= $ticketTipo[$request->get('tipo')];
                $descricao_acao .= "</i>";

                $descricao_acao .= "<br>";

                if ($request->get('equipamento_id')) {   

                $equipamento_anterior = Equipamento::find($ticket_anterior->equipamento_id);

                $equipamento_novo = Equipamento::find($request->get('equipamento_id'));         

                $descricao_acao .= "Equipamento alterado de: <i style='color:red;'>";
                $descricao_acao .= "Nome: ".$equipamento_anterior->nome." ID: ".$equipamento_anterior->id;
                $descricao_acao .= "</i>";
                $descricao_acao .= " Para: <i style='color:blue;'>";             
                $descricao_acao .= "Nome: ".$equipamento_novo->nome." ID: ".$equipamento_novo->id;
                $descricao_acao .= "</i>";

                $descricao_acao .= "<br>";

                }

                $descricao_acao .= "Título alterado de: <i style='color:red;'>";
                $descricao_acao .= $ticket_anterior->titulo;
                $descricao_acao .= "</i>";
                $descricao_acao .= " Para: <i style='color:blue;'>";
                $descricao_acao .= $request->get('titulo');
                $descricao_acao .= "</i>";

                $descricao_acao .= "<br>";

                $descricao_acao .= "Descrição alterado de: <i style='color:red;'>";
                $descricao_acao .= $ticket_anterior->descricao;
                $descricao_acao .= "</i>";
                $descricao_acao .= " Para: <i style='color:blue;'>";
                $descricao_acao .= $request->get('descricao');
                $descricao_acao .= "</i>";

                $tipo_acao="Alteração";
                $tipo_acao_cor="warning";

                $this->storeAcaoAuto($setor, $descricao_acao, $id, $tipo_acao, $tipo_acao_cor);
                /* -----------End Salva mudanças na acao----------- */


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
                                ->orderBy('id', 'DESC')
                                ->get();
            /* .................... END QTD Tickets Abertos ................... */

            /* ........................ Última Ação do Ticket Aberto .............*/

            foreach ($tickets as $ticket) {

                $ticket_prontuario = Ticket::find($ticket->id);
                $prontuarios[$ticket->id] = $ticket_prontuario->prontuarioTicketsShow()->orderBy('id', 'desc')->first();                
            }



            //dd($prontuarios);

            /* ........................ Última Ação do Ticket Aberto .............*/

            /* .................... Últimos Livros ................... */

            $livros = $setor->livros()
                            ->orderBy('id','DESC')
                            ->limit(8)
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
                            'cont_aloc',
                            'prontuarios'
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
        //Area dos tickets sem nenhuma alocacao
        $my_setor = $setor;

        if(!(Gate::denies('read_'.$setor))){  

            /* --------------- Verifica se o ticket não tem alocação ----------------- */

            $ticket = $this->ticket->find($id);

            //recuperar setors
            $setors = $ticket->setors()->get();

            if(($ticket->setors()->count())>0){
                return redirect('erro')->with('permission_error', '403');

            }else{

                //todos setores
                $all_setors = Setor::all();

                //LOG ----------------------------------------------------------------------------------------
                $this->log("tecnico.alocarSetors:".$id);
                //--------------------------------------------------------------------------------------------

            }

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


    public function superBusca (Request $request, $setor){
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
            /*
            $tickets = Ticket::where('titulo','LIKE' , '%'.$buscaInput.'%')
                                ->orwhere('descricao', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('protocolo', 'LIKE', '%'.$buscaInput.'%')
                                ->orderBy('id', 'DESC')
                                ->paginate(40);
            */

            /* ------------------- TICKETS --------------------- */
            $tickets = Ticket::where('tickets.titulo','LIKE' , '%'.$buscaInput.'%')
                                ->orwhere('tickets.descricao', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('tickets.protocolo', 'LIKE', '%'.$buscaInput.'%')
                                ->orderBy('id', 'DESC')
                                ->limit('100')
                                ->get();
            /* --------------------  END TICKETs -----------------*/

            /* ------------------- TICKETS AÇÕES --------------------- */
            $tickets_acoes = DB::table('tickets')
                                ->join('prontuario_tickets', 'tickets.id', '=', 'prontuario_tickets.ticket_id')
                                ->select('tickets.*', 'prontuario_tickets.descricao AS acao_descricao')
                                ->where('tickets.titulo','LIKE' , '%'.$buscaInput.'%')
                                ->orwhere('tickets.descricao', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('tickets.protocolo', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('prontuario_tickets.descricao', 'LIKE', '%'.$buscaInput.'%')
                                ->orderBy('id', 'DESC')
                                ->limit('100')
                                ->get();
            /* --------------------  END TICKETs -----------------*/

            /* ------------------- TICKETS SETORS --------------------- */

            $all_ticket_setors = DB::table('setor_ticket')
                                ->join('setors', 'setors.id', '=', 'setor_ticket.setor_id')
                                ->select('setor_ticket.*', 'setors.name', 'setors.label')
                                ->get();
            
            /* --------------------  END TICKETs SETORS -----------------*/

            /* ------------------- TUTORIAIS -------------------- */
            $tutorials = Tutorial::where('titulo', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('palavras_chave', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('conteudo', 'LIKE', '%'.$buscaInput.'%')
                                ->orderBy('id', 'DESC')
                                ->limit('100')
                                ->get();
            /* ------------------- END TUTORIAIS -------------------- */

            /* ------------------- TUTORIAIS -------------------- */
            $all_tutorial_setors = DB::table('setor_tutorial')
                                ->join('setors', 'setors.id', '=', 'setor_tutorial.setor_id')
                                ->select('setor_tutorial.*', 'setors.name', 'setors.label')
                                ->get();
            /* ------------------- END TUTORIAIS -------------------- */

            /* ------------------- TUTORIAIS -------------------- */
            $livros = Livro::where('protocolo', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('conteudo', 'LIKE', '%'.$buscaInput.'%')
                                ->orderBy('id', 'DESC')
                                ->limit('100')
                                ->get();
            /* ------------------- END TUTORIAIS -------------------- */

            //LOG ----------------------------------------------------------------------------------------
            $this->log("tecnico.SuperBusca=".$buscaInput);
            //--------------------------------------------------------------------------------------------

            $week = $this->weekBr();

            return view('tecnico.super_busca', array(
                                                    'tickets' => $tickets, 
                                                    'tickets_acoes' => $tickets_acoes, 
                                                    'buscar' => $buscaInput, 
                                                    'setor' => $setor,
                                                    'tutorials' => $tutorials,
                                                    'all_tutorial_setors' => $all_tutorial_setors,
                                                    'all_ticket_setors' => $all_ticket_setors,
                                                    'livros' => $livros,
                                                    'week' => $week
                                                ));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


}
