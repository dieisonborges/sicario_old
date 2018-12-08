<?php

namespace App\Http\Controllers;

use App\Equipamento;
use Illuminate\Http\Request;
use Gate;

class EquipamentoController extends Controller
{
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
            return view('equipamento.edit', compact('equipamento','id'));
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
            ]);
                    
        
            
            $equipamento->nome = $request->get('nome');
            $equipamento->part_number = $request->get('part_number');
            $equipamento->serial_number = $request->get('serial_number');
            $equipamento->descricao = $request->get('descricao');

            if ($request->get('sistema_id')) {
                $equipamento->sistema_id = $request->get('sistema_id');
            }


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
            return redirect()->back()->with('success','Equipamento excluído com sucesso!');
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }
}
