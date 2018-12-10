<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Controllers\Log;
use App\Http\Controllers\LogController;

class RegisterController extends Controller
{
    
    /* ----------------------- LOGS ----------------------*/

    private function log($info){
        //path name
        $filename="RegisterController";

        $log = new LogController;
        $log->store($filename, $info);
        return null;     
    }

    /* ----------------------- END LOGS --------------------*/


    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //LOG ----------------------------------------------------------------------------------------
        $this->log("guest");
        //--------------------------------------------------------------------------------------------

        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        

        //Limpar acentos e espaços CPF
        //$data['cpf'] = ExtraFunc::sanitizeString($data['cpf']);

        //Remove toda a pontuação do CPF
        $data['cpf']  = preg_replace('/\D/', '', $data['cpf']);

        //Remove a pontuzação do TELEFONE (99) 99999-9999        
        $data['telefone']  = preg_replace('/\D/', '', $data['telefone']);
        $ddd = substr($data['telefone'], 0, 2);
        $ntelpre = substr($data['telefone'], 2, 5);
        $ntel = substr($data['telefone'], 7, 4); 
        $data['telefone'] = "(".$ddd.")".$ntelpre."-".$ntel;


        //Limpar acentos e espaços Telefone
        //$data['telefone'] = sanitizeString($data['telefone']);

        //LOG ----------------------------------------------------------------------------------------
        $this->log("register.validator:".$data['name']." ".$data['cargo']." ".$data['email']." ".$data['cpf']." ".$data['telefone']." ".(Hash::make($data['password'])));
        //--------------------------------------------------------------------------------------------


        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',            
            'cpf' => 'required|string|cpf|unique:users',
            'telefone' => 'required|string|celular_com_ddd',
            'password' => ['required','string','min:6','max:20','confirmed','regex:(^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$)'],            
        ], [
            'regex' => 'No campo :attribute é obrigatório para criação de senhas, pelo menos um caracter maiúsculo, minúsculo e número. Mínimo 8 digitos e máximo 20',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        //Remove toda a pontuação do CPF
        $data['cpf']  = preg_replace('/\D/', '', $data['cpf']);

        //LOG ----------------------------------------------------------------------------------------
        $this->log("register.create:".$data['name']." ".$data['cargo']." ".$data['email']." ".$data['cpf']." ".$data['telefone']." ".(Hash::make($data['password'])));
        //--------------------------------------------------------------------------------------------
        
        return User::create([
            'name' => $data['name'],
            'cargo' => $data['cargo'],
            'email' => $data['email'],
            'cpf' => $data['cpf'],
            'telefone' => $data['telefone'],
            'password' => Hash::make($data['password']),

        ]);
    }
}
