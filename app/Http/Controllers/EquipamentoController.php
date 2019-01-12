<?php

namespace App\Http\Controllers;

use App\Equipamento;
use App\Sistema;
use App\User;
use Illuminate\Http\Request;
use Gate;

//Log
use App\Http\Controllers\Log;
use App\Http\Controllers\LogController;

class EquipamentoController extends Controller
{
    
    /* ----------------------- LOGS ----------------------*/

    private function log($info){
        //path name
        $filename="EquipamentoController";

        $log = new LogController;
        $log->store($filename, $info);
        return null;     
    }

    /* ----------------------- END LOGS --------------------*/


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!(Gate::denies('read_equipamento'))){
            $equipamentos = Equipamento::paginate(40);     

            //LOG ----------------------------------------------------------------------------------------
            $this->log("equipamento.index");
            //--------------------------------------------------------------------------------------------

            return view('equipamento.index', array('equipamentos' => $equipamentos, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function busca (Request $request){
        if(!(Gate::denies('read_equipamento'))){
            $buscaInput = $request->input('busca');
            $equipamentos = Equipamento::where('nome', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('part_number', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('serial_number', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('descricao', 'LIKE', '%'.$buscaInput.'%')
                                ->paginate(40);  

            //LOG ----------------------------------------------------------------------------------------
            $this->log("equipamento.busca=".$buscaInput);
            //--------------------------------------------------------------------------------------------

            return view('equipamento.index', array('equipamentos' => $equipamentos, 'buscar' => $buscaInput ));
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
        if(!(Gate::denies('create_equipamento'))){

            //LOG ----------------------------------------------------------------------------------------
            $this->log("equipamento.create");
            //--------------------------------------------------------------------------------------------
        
            return view('equipamento.create');
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
        if(!(Gate::denies('create_equipamento'))){
            //Validação
            $this->validate($request,[
                    'nome' => 'required|min:3',
                    /*'part_number' => 'unique:equipamentos',*/
                    'serial_number' => '',
                    'descricao' => 'required|min:15',
            ]);
           
                    
            $equipamento = new Equipamento();
            $equipamento->nome = $request->input('nome');
            $equipamento->part_number = $request->input('part_number');
            $equipamento->serial_number = $request->input('serial_number');
            $equipamento->descricao = $request->input('descricao');

            if ($request->input('sistema_id')) {
                $equipamento->sistema_id = $request->input('sistema_id');
            }
            
            //LOG ----------------------------------------------------------------------------------------
            $this->log("equipamento.store");
            //--------------------------------------------------------------------------------------------

            if($equipamento->save()){
                return redirect('equipamentos/')->with('success', 'Equipamento cadastrado com sucesso!');
            }else{
                return redirect('equipamentos/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
         if(!(Gate::denies('read_equipamento'))){
            $equipamento = Equipamento::find($id);

            //LOG ----------------------------------------------------------------------------------------
            $this->log("equipamento.show=".$id);
            //--------------------------------------------------------------------------------------------

            return view('equipamento.show', array('equipamento' => $equipamento));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if(!(Gate::denies('update_equipamento'))){            
            $equipamento = Equipamento::find($id);

            $sistemas = Sistema::all();

            //LOG ----------------------------------------------------------------------------------------
            $this->log("equipamento.edit=".$id);
            //--------------------------------------------------------------------------------------------

            return view('equipamento.edit', compact('equipamento','id', 'sistemas'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(!(Gate::denies('update_equipamento'))){
            $equipamento = Equipamento::find($id);

            //Validação
            $this->validate($request,[
                    'nome' => 'required|min:3',
                    /*'part_number' => 'unique:equipamentos',*/
                    'serial_number' => '',
                    'descricao' => 'required|min:15',
                    //'sistema_id' => 'required',
            ]);                   
        
            
            $equipamento->nome = $request->get('nome');
            $equipamento->part_number = $request->get('part_number');
            $equipamento->serial_number = $request->get('serial_number');
            $equipamento->descricao = $request->get('descricao');

            if ($request->get('sistema_id')) {
                $equipamento->sistema_id = $request->get('sistema_id');
            }

            //LOG ----------------------------------------------------------------------------------------
            $this->log("equipamento.update=".$id);
            //--------------------------------------------------------------------------------------------


            if($equipamento->save()){
                return redirect('equipamentos/')->with('success', 'Equipamento atualizado com sucesso!');
            }else{
                return redirect('equipamentos/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Equipamento  $equipamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(!(Gate::denies('delete_equipamento'))){
            $equipamento = Equipamento::find($id);        
            
            $equipamento->delete();

            //LOG ----------------------------------------------------------------------------------------
            $this->log("equipamento.destroy=".$id);
            //--------------------------------------------------------------------------------------------

            return redirect()->back()->with('success','Equipamento excluído com sucesso!');
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


    /* ------------------------------ DASHBOARD --------------------------*/
    public function dashboard()
    {
        //
        if(!(Gate::denies('read_equipamento'))){

            //carrega todos os sistemas Cadastrados
            $sistemas = Sistema::all(); 

            //Sistema Nomes

            foreach ($sistemas as $sistema_tmp) {
                $sistema_nome[$sistema_tmp->id] =  $sistema_tmp->nome;
            }

            /* --------------------Tickets por Sistema --------------------- */

            foreach ($sistemas as $sistema) {

                

                $equipamentos = Equipamento::where('sistema_id', $sistema->id)->get();

                //Todos os TICKETs ABERTOS
                $sistema_ticket_qtd_abertos[$sistema->id]=0;
                foreach ($equipamentos as $equipamento) {

                        $equipamento_find = Equipamento::find($equipamento->id);
                    
                        $sistema_ticket_qtd_abertos[$sistema->id]+= $equipamento_find
                                                                        ->tickets()
                                                                        ->where('status', '1')
                                                                        ->count();

                }

                //Todos os TICKETs FECHADOS
                $sistema_ticket_qtd_fechados[$sistema->id]=0;
                foreach ($equipamentos as $equipamento) {

                        $equipamento_find = Equipamento::find($equipamento->id);
                    
                        $sistema_ticket_qtd_fechados[$sistema->id]+= $equipamento_find
                                                                        ->tickets()
                                                                        ->where('status', '0')
                                                                        ->count();

                }

            }

            /* --------------------- Verifica setor do usuário -------------------*/

            $usuario = User::find(auth()->user()->id);

            $setor = $usuario->setors()->first();


            if(!isset($setor)){
                return redirect('equipamentos/dashboard/')->with('danger', 'Vocẽ não está alocado em nenhum setor.');
            }
            
            /* ----------------------- END Verifica setor do usuário --------------------- */

            
            

            /* --------------------FIM Tickets por Sistema --------------------- */

            $equipamentos_inops = Equipamento::where('status', 0)->orderBy('sistema_id')->get();


            //LOG ----------------------------------------------------------------------------------------
            $this->log("equipamento.dashboard");
            //--------------------------------------------------------------------------------------------



            return view('equipamento.dashboard', compact('sistemas', 'sistema_ticket_qtd_abertos', 'sistema_ticket_qtd_fechados', 'equipamentos_inops', 'sistema_nome', 'setor'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }
    /* ----------------------------- END DASHBOARD ---------------------*/

    /* ------------------------------ DASHBOARD SISTEMA --------------------------*/
    public function dashboardSistema($id)
    {
        
        //
        if(!(Gate::denies('read_equipamento'))){

            //carrega todos os sistemas Cadastrados
            $sistema = Sistema::find($id); 

            $equipamentos = $sistema->equipamentos()->get();
            
            //LOG ----------------------------------------------------------------------------------------
            $this->log("equipamento.dashboardsistema");
            //--------------------------------------------------------------------------------------------

            /* --------------------- Verifica setor do usuário -------------------*/

            $usuario = User::find(auth()->user()->id);

            $setor = $usuario->setors()->first();


            if(!isset($setor)){
                return redirect('equipamentos/dashboard/')->with('danger', 'Vocẽ não está alocado em nenhum setor.');
            }
            
            /* ----------------------- END Verifica setor do usuário --------------------- */



            return view('equipamento.dashboardsistema', compact('sistema', 'equipamentos', 'setor', 'tickets'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }
    /* ----------------------------- END DASHBOARD SISTEMA ---------------------*/


    public function status($id, $status, $sistema)
    {
        //
        if(!(Gate::denies('read_equipamento'))){

            $equipamento = Equipamento::find($id);            
            
            //LOG ----------------------------------------------------------------------------------------
            $this->log("equipamento.index.status=".$status);
            //--------------------------------------------------------------------------------------------

            $equipamento->status = $status;            

            //LOG ----------------------------------------------------------------------------------------
            $this->log("ticket.update.id=".$id);
            //--------------------------------------------------------------------------------------------

            if($equipamento->save()){
                return redirect('equipamentos/dashboard/'.$sistema)->with('success', 'Status atualizado com sucesso!');
            }else{
                return redirect('equipamentos/dashboard/'.$sistema)->with('danger', 'Houve um problema, tente novamente.');
            }
        }


        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

}
