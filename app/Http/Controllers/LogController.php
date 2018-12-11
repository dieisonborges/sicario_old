<?php

namespace App\Http\Controllers;

use App\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\User;
use Gate;
use DB;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!(Gate::denies('read_log'))){
            $logs = Log::orderBy('created_at', 'DESC')->paginate(100);         
            return view('log.index', array('logs' => $logs, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function busca (Request $request){
        if(!(Gate::denies('read_log'))){
            $buscaInput = $request->input('busca');
            $logs = Log::where('ip', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('mac', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('host', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('filename', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('info', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('user_id', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('created_at', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('updated_at', 'LIKE', '%'.$buscaInput.'%')
                                ->orderBy('created_at', 'DESC')
                                ->paginate(100);        
            return view('log.index', array('logs' => $logs, 'buscar' => $buscaInput ));
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
    public function store($filename, $info)
    {
     
        $log = new Log();
        $log->ip = request()->ip();

        $logmac = shell_exec("arp -an ".$log->ip."");

        if(isset($logmac)){
            /* tratar MAC */
            $logmac = explode("at", $logmac);
            if(isset($logmac[1])){
                $logmac = explode("on", $logmac[1]);
                if(isset($logmac[0])){
                   $log->mac = $logmac[0]; 
                }else{
                    $log->mac = "None";
                }   
            }else{
                $log->mac = "None";
            }            
            /* END tratar MAC */

        }else{
            $log->mac = "None";
        }

       if(isset($_SERVER["REMOTE_ADDR"])){
            $log->host = array_key_exists( 'REMOTE_HOST', $_SERVER) ? $_SERVER['REMOTE_HOST'] : gethostbyaddr($_SERVER["REMOTE_ADDR"]);

       }else{
            $log->host = "None";
       }

        

       
        $log->filename = $filename;
        

        if (auth()->check()) {
            $log->user_id = auth()->user()->id;
            $username = auth()->user()->cargo." ".auth()->user()->name;
        }else{
            $username = "Não necessita login";
        }        
        
        $log->info = $username." | ".$info;

        if($log->save()){
            return true;
        }else{
            return false;
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        if(!(Gate::denies('read_log'))){
            $log = Log::find($id);

            $user = User::find($log->user_id);

            return view('log.show', compact('log', 'user'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }


    public function acesso (){
        //
        if(!(Gate::denies('read_log'))){
            $logs = Log::select('ip', 'mac')
                        ->distinct('ip')
                        //->orderBy('created_at', 'DESC')
                        ->get();         
            return view('log.acesso', array('logs' => $logs, 'buscar' => null));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    
}
