<?php

namespace App\Http\Controllers;

use App\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use Gate;

class SetorController extends Controller
{
    
    private $setor;

    public function __construct(Setor $setor){
        $this->setor = $setor;        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 
        if(!(Gate::denies('read_setor'))){
            $setors = Setor::paginate(40);         
            return view('setor.index', array('setors' => $setors, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function busca (Request $request){
        if(!(Gate::denies('read_setor'))){
            $buscaInput = $request->input('busca');

            $setors = Setor::where('name', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('label', 'LIKE', '%'.$buscaInput.'%')
                                ->paginate(40);        
            return view('setor.index', array('setors' => $setors, 'buscar' => $buscaInput ));
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
        if(!(Gate::denies('create_setor'))){
            return view('setor.create');                  
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
        if(!(Gate::denies('create_setor'))){
            //Validação
            $this->validate($request,[
                    'name' => 'required|min:3|unique:setors',
                    'label' => 'required|min:3|unique:setors',                
            ]);

            
                    
            $setor = new Setor();
            $setor->name = $request->input('name');
            $setor->label = $request->input('label');

            if($setor->save()){
                return redirect('setors/')->with('success', 'Setor cadastrado com sucesso!');
            }else{
                return redirect('setors/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function show(Setor $setor)
    {
        //
        if(!(Gate::denies('read_setor'))){
            $setor = Setor::find($id);
            return view('setor.show', array('setor' => $setor));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if(!(Gate::denies('update_setor'))){        
            $setor = Setor::find($id);
            return view('setor.edit', compact('setor','id'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(!(Gate::denies('update_setor'))){
            $setor = Setor::find($id);

            //Validação
            $this->validate($request,[
                    'name' => 'required|min:3|unique:setors',
                    'label' => 'required|min:3|unique:setors',       
            ]);
                    
            $setor->name = $request->get('name');
            $setor->label = $request->get('label');       

            if($setor->save()){
                return redirect('setors/')->with('success', 'Setor (Regra) atualizada com sucesso!');
            }else{
                return redirect('setors/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Setor  $setor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(!(Gate::denies('delete_setor'))){
            $setor = Setor::find($id);        
            
            $setor->delete();
            return redirect()->back()->with('success','Setor (Regra) excluída com sucesso!');
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }
}
