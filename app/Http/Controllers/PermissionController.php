<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Permission;
use Gate;

class PermissionController extends Controller
{ 
    //
    private $permission;

    public function __construct(Permission $permission){
        $this->permission = $permission;
    }

    public function index(){
        if(!(Gate::denies('read_permission'))){
        	$permissions = Permission::paginate(40);         
        	return view('permission.index', array('permissions' => $permissions, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    // Seleciona por id
    public function show($id){
        if(!(Gate::denies('read_permission'))){
            $permission = Permission::find($id);
            return view('permission.show', array('permission' => $permission));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function busca (Request $request){
        if(!(Gate::denies('read_permission'))){
            $buscaInput = $request->input('busca');
            $permissions = Permission::where('name', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('label', 'LIKE', '%'.$buscaInput.'%')
                                ->paginate(40);        
            return view('permission.index', array('permissions' => $permissions, 'buscar' => $buscaInput ));

        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    // Criar
    public function create(){
        if(!(Gate::denies('read_permission'))){
        
            return view('permission.create');
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }      

    }

    // Criar usuário
    public function store(Request $request){
        if(!(Gate::denies('read_permission'))){
            //Validação
            $this->validate($request,[
                    'name' => 'required|min:3|unique:permissions',
                    'label' => 'required|min:3|unique:permissions',                
            ]);

            
                    
            $permission = new Permission();
            $permission->name = $request->input('name');
            $permission->label = $request->input('label');

            if($permission->save()){
                return redirect('permissions/')->with('success', 'Permission (Regra) cadastrada com sucesso!');
            }else{
                return redirect('permissions/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function edit($id){  
        if(!(Gate::denies('read_permission'))){
            
            $permission = Permission::find($id);

            return view('permission.edit', compact('permission','id'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }        

    }

    public function update(Request $request, $id){
        if(!(Gate::denies('read_permission'))){
            $permission = Permission::find($id);

            //Validação
            $this->validate($request,[
                    'name' => 'required|min:3|unique:permissions',
                    'label' => 'required|min:3|unique:permissions',       
            ]);
                    
            $permission->name = $request->get('name');
            $permission->label = $request->get('label');       

            if($permission->save()){
                return redirect('permissions/')->with('success', 'Permission (Regra) atualizada com sucesso!');
            }else{
                return redirect('permissions/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }

        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function destroy($id){
        if(!(Gate::denies('read_permission'))){
            $permission = Permission::find($id);        
            
            $permission->delete();
            return redirect()->back()->with('success','Permission (Regra) excluída com sucesso!');

        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function roles($id){
        if(!(Gate::denies('read_permission'))){
            //Recupera Permission
            $permission = Permission::find($id);

            //recuperar roles
            $roles = $permission->roles()->get();

            return view('permission.role', compact('permission', 'roles'));

        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }


    }

}
