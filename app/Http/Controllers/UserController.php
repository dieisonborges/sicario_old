<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Role;
use App\Setor;
use Gate;
use DB;

class UserController extends Controller
{
    //
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(){
        if(!(Gate::denies('read_user'))){
        	$user = User::paginate(40);         
        	return view('user.index', array('users' => $user, 'buscar' => null));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    // Seleciona por id
    public function show($id){
        if(!(Gate::denies('read_user'))){
            $user = User::find($id);
            return view('user.show', array('user' => $user));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }


    public function busca (Request $request){
        if(!(Gate::denies('read_user'))){
            $buscaInput = $request->input('busca');
            $user = User::where('name', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('email', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('telefone', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('cpf', 'LIKE', '%'.$buscaInput.'%')
                                ->paginate(40);        
            return view('user.index', array('users' => $user, 'buscar' => $buscaInput ));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    // Criar 
    public function create(){
        if(!(Gate::denies('create_user'))){
        
            return view('user.create');
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }       

    }

    // Criar 
    public function store(Request $request){
        if(!(Gate::denies('create_user'))){
            //Validação
            $this->validate($request,[
                    'name' => 'required|min:3',
                    'cargo' => 'required|min:3',
                    'email' => 'required|min:3|unique:users',
                    'cpf' => 'required|min:3|unique:users',
                    'telefone' => 'required|min:3',
                    'status' => 'required|numeric',
                    'login' => 'required|numeric',
            ]);

            
                    
            $user = new User();
            $user->name = $request->input('name');
            $user->cargo = $request->input('cargo');
            $user->email = $request->input('email');
            $user->cpf = $request->input('cpf');
            $user->telefone = $request->input('telefone');
            $user->status = $request->input('status');
            $user->login = $request->input('login');  

            //Senha Aleatória
            $user->password  = bcrypt(md5(rand()));


            //Remove toda a pontuação do CPF
            $user['cpf']  = preg_replace('/\D/', '', $user['cpf']);

            //Remove a pontuzação do TELEFONE (99) 99999-9999        
            $user['telefone']  = preg_replace('/\D/', '', $user['telefone']);
            $ddd = substr($user['telefone'], 0, 2);
            $ntelpre = substr($user['telefone'], 2, 5);
            $ntel = substr($user['telefone'], 7, 4); 
            $user['telefone'] = "(".$ddd.")".$ntelpre."-".$ntel;


            if($user->save()){
                return redirect('users/')->with('success', 'Usuário cadastrado com sucesso!');
            }else{
                return redirect('users/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }

    public function edit($id){  
        if(!(Gate::denies('update_user'))){
        
            $user = User::find($id);
            return view('user.edit', compact('user','id'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }

    public function update(Request $request, $id){
        if(!(Gate::denies('update_user'))){
            $user = User::find($id);

            //Validação
            $this->validate($request,[
                    'name' => 'required|min:3',
                    'cargo' => 'required|min:3',
                    'email' => 'required|min:3',
                    'cpf' => 'required|min:3',
                    'telefone' => 'required|min:3',
                    'status' => 'required|numeric',
                    'login' => 'required|numeric',
            ]);
                    
        
            $user->name = $request->get('name');
            $user->cargo = $request->get('cargo');
            $user->email = $request->get('email');
            $user->cpf = $request->get('cpf');
            $user->telefone = $request->get('telefone');
            $user->status = $request->get('status');
            $user->login = $request->get('login');        

            if($user->save()){
                return redirect('users/')->with('success', 'Usuário atualizado com sucesso!');
            }else{
                return redirect('users/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }

    public function updateActive(Request $request){
        if(!(Gate::denies('update_user'))){
            // $flag = 1 ATIVO ou 0 INATIVO

            $status = $request->input('status');
            $id = $request->input('id');

            $user = User::find($id);

            if($status){
                $user->status = 1;
                $user->login = 0;
            }else{
                $user->status = 0;
                $user->login = 16; //Maior que 16 bloqueia o login (Tentativas)
            }
                    

            if($user->save()){
                return redirect('users/')->with('success', 'Usuário atualizado com sucesso!');
            }else{
                return redirect('users/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }

    public function destroy($id){
        if(!(Gate::denies('delete_user'))){
            $user = User::find($id);        
            
            $user->delete();
            return redirect()->back()->with('success','Usuário excluído com sucesso!');
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    public function roles($id){
        if(!(Gate::denies('read_user'))){        
            //Recupera User
            $user = $this->user->find($id);

            //recuperar roles
            $roles = $user->roles()->get();

            //todas permissoes
            $all_roles = Role::all();

            return view('user.role', compact('user', 'roles', 'all_roles'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }


    }





    public function roleUpdate(Request $request){

        if(!(Gate::denies('update_role'))){            
                    
            
            $role_id = $request->input('role_id');
            $user_id = $request->input('user_id'); 

            $user  = User::find($user_id);

            $status = Role::find($role_id)->roleUser()->attach($user->id);
          
            if(!$status){
                return redirect('user/'.$user_id.'/roles')->with('success', 'Role (Regra) atualizada com sucesso!');
            }else{
                return redirect('user/'.$user_id.'/roles')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }

    public function roleDestroy(Request $request){

        if(!(Gate::denies('delete_role'))){

            $role_id = $request->input('role_id');
            $user_id = $request->input('user_id');  

            $user = User::find($user_id); 
            $role = Role::find($role_id);

            $status = $role ->roleUser()->detach($user->id);

            
            if($status){
                return redirect('user/'.$user_id.'/roles')->with('success', 'Role (Regra) excluída com sucesso!');
            }else{
                return redirect('user/'.$user_id.'/roles')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }


    public function setors($id){        
        if(!(Gate::denies('read_user'))){        
            //Recupera User
            $user = $this->user->find($id);

            //recuperar setors
            $setors = $user->setors()->get();

            //todas permissoes
            $all_setors = Setor::all();

            return view('user.setor', compact('user', 'setors', 'all_setors'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }


    public function setorUpdate(Request $request){

        if(!(Gate::denies('update_setor'))){            
                    
            
            $setor_id = $request->input('setor_id');
            $user_id = $request->input('user_id'); 

            $user  = User::find($user_id);

            $status = Setor::find($setor_id)->setorUser()->attach($user->id);
          
            if(!$status){
                return redirect('user/'.$user_id.'/setors')->with('success', 'Setor (Regra) atualizada com sucesso!');
            }else{
                return redirect('user/'.$user_id.'/setors')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }

    public function setorDestroy(Request $request){

        if(!(Gate::denies('delete_setor'))){

            $setor_id = $request->input('setor_id');
            $user_id = $request->input('user_id');  

            $user = User::find($user_id); 
            $setor = Setor::find($setor_id);

            $status = $setor ->setorUser()->detach($user->id);

            
            if($status){
                return redirect('user/'.$user_id.'/setors')->with('success', 'Setor (Regra) excluída com sucesso!');
            }else{
                return redirect('user/'.$user_id.'/setors')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    

        /*

    public function roleUpdateTest(){

        //Request $request
            
        //$role_id = $request->input('role_id');
        //$user_id = $request->input('user_id');    

        $role_id = "1";
        $user_id = "22";    

        $user  = User::find($user_id);

        if(Role::find($role_id)->roleUser()->attach($user->id)){
            dd("ok");
        }else{
            dd("problem");
        }
        

    }

    */
    
    
}
