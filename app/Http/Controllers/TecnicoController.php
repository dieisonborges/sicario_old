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

class TecnicoController extends Controller
{
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

        $protocolo = $chars[rand (0 , 25)];
        $protocolo .= $chars[rand (0 , 25)];
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

    public function index($setor)
    {
        
        //
        if(!(Gate::denies('create_'.$setor))){

            //usuário
            $user_id = auth()->user()->id;

            //setor
            $setors = Setor::where('name', $setor)->limit(1)->get();

            foreach ($setors as $setor ) {
                $temp_setor = $setor;
            }

            $setor = $temp_setor;

            $tickets = $setor->tickets()->paginate(40);

            //$tickets = Ticket::where('setor_id', $setor->id)->paginate(40);

            return view('tecnico.index', array('setor' => $setor, 'tickets' => $tickets, 'buscar' => null));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

}
