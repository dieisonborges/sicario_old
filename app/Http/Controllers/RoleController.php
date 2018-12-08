<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use App\Role;
use App\Permission;
use App\PermissionRole;
use Gate;

class RoleController extends Controller
{
    //
    private $role;

    public function __construct(Role $role){
        $this->role = $role;        
    }

    public function index(){
        if(!(Gate::denies('read_role'))){
            $roles = Role::paginate(40);         
        	return view('role.index', array('roles' => $roles, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    // Seleciona por id
    public function show($id){
        if(!(Gate::denies('read_role'))){
            $role = Role::find($id);
            return view('role.show', array('role' => $role));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function busca (Request $request){
        if(!(Gate::denies('read_role'))){
            $buscaInput = $request->input('busca');

            $roles = Role::where('name', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('label', 'LIKE', '%'.$buscaInput.'%')
                                ->paginate(40);        
            return view('role.index', array('roles' => $roles, 'buscar' => $buscaInput ));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    // Criar
    public function create(){
        if(!(Gate::denies('create_role'))){
            return view('role.create');                  
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    // Criar usuário
    public function store(Request $request){
        if(!(Gate::denies('create_role'))){
            //Validação
            $this->validate($request,[
                    'name' => 'required|min:3|unique:roles',
                    'label' => 'required|min:3|unique:roles',                
            ]);

            
                    
            $role = new Role();
            $role->name = $request->input('name');
            $role->label = $request->input('label');

            if($role->save()){
                return redirect('roles/')->with('success', 'Role (Regra) cadastrada com sucesso!');
            }else{
                return redirect('roles/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function edit($id){  
        if(!(Gate::denies('update_role'))){        
            $role = Role::find($id);
            return view('role.edit', compact('role','id'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
         


    }

    public function update(Request $request, $id){
        if(!(Gate::denies('update_role'))){
            $role = Role::find($id);

            //Validação
            $this->validate($request,[
                    'name' => 'required|min:3|unique:roles',
                    'label' => 'required|min:3|unique:roles',       
            ]);
                    
            $role->name = $request->get('name');
            $role->label = $request->get('label');       

            if($role->save()){
                return redirect('roles/')->with('success', 'Role (Regra) atualizada com sucesso!');
            }else{
                return redirect('roles/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function destroy($id){
        if(!(Gate::denies('delete_role'))){
            $role = Role::find($id);        
            
            $role->delete();
            return redirect()->back()->with('success','Role (Regra) excluída com sucesso!');
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function permissions($id){
        if(!(Gate::denies('read_role'))){
            //Recupera a permissão
            $role = Role::find($id);

            //recuperar permissões
            $permissions = $role->permissions()->get();

            //todas permissoes
            $all_permissions = Permission::all();

            return view('role.permission', compact('role', 'permissions', 'all_permissions'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }


    }

    public function permissionUpdate(Request $request){

        if(!(Gate::denies('update_role'))){

            $role_id = $request->input('role_id');
            $permission_id = $request->input('permission_id'); 

            $role  = Role::find($role_id);

            $status = Permission::find($permission_id)->permissionRole()->attach($role_id);
            
            if(!$status){
                return redirect('role/'.$role_id.'/permissions')->with('success', 'Role (Regra) atualizada com sucesso!');
            }else{
                return redirect('role/'.$role_id.'/permissions')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }

    }

    public function permissionDestroy(Request $request){
        if(!(Gate::denies('delete_role'))){

            /* -------------------- */

            $role_id = $request->input('role_id');
            $permission_id = $request->input('permission_id'); 

            $permission  = Permission::find($permission_id);

            $status = $permission->permissionRole()->detach($role_id);
            
            if($status){
                return redirect('role/'.$role_id.'/permissions')->with('success', 'Role (Regra) excluída com sucesso!');
            }else{
                return redirect('role/'.$role_id.'/permissions')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }



}
