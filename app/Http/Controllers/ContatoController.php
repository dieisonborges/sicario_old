<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Gate;

class ContatoController extends Controller
{
    
	public function index(){
		//$data['titulo']= "Minha Página de Contato";
		if(Auth::check()){
    		return view('email.index');
    	}else{
            return redirect('login')->with('danger', 'Erro: <b>400</b> Você não fez login no sistema');
        }
	}

	public function enviar(Request $request){
		if(Auth::check()){
				$dadosEmail = array(
					'nome' => $request->input('nome'),
					'email' => $request->input('email'),
					'assunto' => $request->input('assunto'),
					'msg' => $request->input('msg'),
				);

				Mail::send('email.contato', $dadosEmail, function($message){
					$message->from('dieisondsb@fab.mil.br','SICARIO');
					$message->subject('Contato SICARIO');
					$message->to('dieisondsb@fab.mil.br');
				});

				return redirect('contato')->with('success', 'Mensagem enviada em breve entraremos em contato!');
		}else{
            return redirect('login')->with('danger', 'Erro: <b>400</b> Você não fez login no sistema');
        }
	}
    
}
