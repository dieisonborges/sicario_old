<?php
 
namespace App\Http\Controllers;

use App\Ticket;
use App\Equipamento;
use Illuminate\Http\Request;
use Gate;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(!(Gate::denies('read_ticket'))){

            $tickets = Ticket::paginate(40);

            //recuperar equipamentos
            //$equipamentos = $tickets->equipamentos()->get();

            $equipamentos = "test";

            //recuperar usuários
            //$users = $tickets->users()->get();

            $users = "test";

            return view('ticket.index', array('tickets' => $tickets, 'buscar' => null, 'equipamentos'=> $equipamentos, 'users'=> $users));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
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
                0   =>  "Crítico - Emergência (reparar imediatamente)",
                1   =>  "Administrativo",
                2   =>  "Médio - Intermediária (avaliar componente)",
                3   =>  "Baixo - Rotina de Manutenção",
                4   =>  "Nenhum",
            );

        return $rotulo;
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


    public function busca (Request $request){
        if(!(Gate::denies('read_ticket'))){
            $buscaInput = $request->input('busca');
            $tickets = Ticket::where('nome', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('part_number', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('serial_number', 'LIKE', '%'.$buscaInput.'%')
                                ->orwhere('descricao', 'LIKE', '%'.$buscaInput.'%')
                                ->paginate(40);        
            return view('ticket.index', array('tickets' => $tickets, 'buscar' => $buscaInput ));
        }
        else{
            return redirect('home')->with('permission_error', '403');
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
        if(!(Gate::denies('create_ticket'))){
            $equipamentos = Equipamento::all(); 
            return view('ticket.create', compact('equipamentos'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
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
        if(!(Gate::denies('create_ticket'))){
            //Validação
            $this->validate($request,[
                    'status' => 'required|integer',
                    'titulo' => 'required|string|max:30',
                    'descricao' => 'required|string|min:15',
                    'rotulo' => 'required|integer',
                    'tipo' => 'required|integer|min:0|max:2',
                    
            ]);
           

            $ticket = new Ticket();
            $ticket->status = $request->input('status');
            $ticket->titulo = $request->input('titulo');
            $ticket->descricao = $request->input('descricao');
            $ticket->rotulo = $request->input('rotulo');
            $ticket->tipo = $request->input('tipo');

            //usuário
            $ticket->user_id = auth()->user()->id;

            //protocolo humano
            $ticket->protocolo = $this->protocolo();

            if ($request->input('equipamento_id')) {
                $ticket->equipamento_id = $request->input('equipamento_id');
            }
            


            if($ticket->save()){
                return redirect('tickets/')->with('success', 'Ticket cadastrado com sucesso!');
            }else{
                return redirect('tickets/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
        if(!(Gate::denies('read_ticket'))){
            $ticket = Ticket::find($id);
            return view('ticket.show', array('ticket' => $ticket));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
         if(!(Gate::denies('update_ticket'))){            
            $ticket = Ticket::find($id);  

            //Tipos
            $tipos = $this->ticketTipo();

            //Rotulos
            $rotulos = $this->ticketRotulo();

            //recuperar permissões
            $equipamentos = $ticket->equipamentos()->get();

            //Captura os dados do equipamento vinculado
            $equipamento = $equipamentos[0];

            return view('ticket.edit', compact('ticket','id', 'tipos', 'rotulos', 'equipamento'));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if(!(Gate::denies('update_ticket'))){
            $ticket = Ticket::find($id);

            //Validação
            $this->validate($request,[
                    'nome' => 'required|min:3',
                    /*'part_number' => 'unique:tickets',*/
                    'serial_number' => '',
                    'descricao' => 'required|min:15',
            ]);
                    
        
            
            $ticket->nome = $request->get('nome');
            $ticket->part_number = $request->get('part_number');
            $ticket->serial_number = $request->get('serial_number');
            $ticket->descricao = $request->get('descricao');

            if ($request->get('sistema_id')) {
                $ticket->sistema_id = $request->get('sistema_id');
            }


            if($ticket->save()){
                return redirect('tickets/')->with('success', 'Ticket atualizado com sucesso!');
            }else{
                return redirect('tickets/'.$id.'/edit')->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(!(Gate::denies('delete_ticket'))){
            $ticket = Ticket::find($id);        
            
            $ticket->delete();
            return redirect()->back()->with('success','Ticket excluído com sucesso!');
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
    }
}
