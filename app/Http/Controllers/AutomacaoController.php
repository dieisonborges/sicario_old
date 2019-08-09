<?php

namespace App\Http\Controllers;

use App\Automacao;
use Illuminate\Http\Request;
use Gate;

class AutomacaoController extends Controller
{
    
    /* ----------------------- LOGS ----------------------*/

    private function log($info){
        //path name
        $filename="AutomacaoController";

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
        //
        if(!(Gate::denies('read_automacao'))){
            

            //LOG -----------------------------------------------------------------
            $this->log("tautomacao.index");
            //---------------------------------------------------------------------

            return view('automacao.index');
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function comando($comando)
    {
        //
        //
        if(!(Gate::denies('read_automacao'))){
            

            //LOG -----------------------------------------------------------------
            $this->log("automacao.comando=".$comando);
            //---------------------------------------------------------------------

            // Define porta onde arduino está conectado
            $port = "/dev/ttyACM0";
             
            // Configura velocidade de comunicação com a porta serial
            exec("stty -F $port raw speed 9600");
            
             
            // Inicia comunicação serial
            $fp = fopen($port, 'w+');
                         
             
            
            if($comando=="brilho1"){

                fwrite($fp, "ONBRILHO1");

            }

            if($comando=="brilho2"){

                fwrite($fp, "ONBRILHO2");

            }

            if($comando=="brilho3"){

                fwrite($fp, "ONBRILHO3");

            }

            if($comando=="brilhooff"){

                fwrite($fp, "OFFBRILHO");

            }

            // Fecha a comunicação serial
            fclose($fp);

            return redirect()->back()->with('success','Comando executado com sucesso!');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Automacao  $automacao
     * @return \Illuminate\Http\Response
     */
    public function show(Automacao $automacao)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Automacao  $automacao
     * @return \Illuminate\Http\Response
     */
    public function edit(Automacao $automacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Automacao  $automacao
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Automacao $automacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Automacao  $automacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Automacao $automacao)
    {
        //
    }
}
