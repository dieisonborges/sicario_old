<?php
 
namespace App\Http\Controllers;

use App\Ticket;
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
            return view('ticket.index', array('tickets' => $tickets, 'buscar' => null));
        }
        else{
            return redirect('home')->with('permission_error', '403');
        }
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
        
            return view('ticket.create');
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
                    'nome' => 'required|min:3',
                    /*'part_number' => 'unique:tickets',*/
                    'serial_number' => '',
                    'descricao' => 'required|min:15',
            ]);
           
                    
            $ticket = new Ticket();
            $ticket->nome = $request->input('nome');
            $ticket->part_number = $request->input('part_number');
            $ticket->serial_number = $request->input('serial_number');
            $ticket->descricao = $request->input('descricao');

            if ($request->input('sistema_id')) {
                $ticket->sistema_id = $request->input('sistema_id');
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
            return view('ticket.edit', compact('ticket','id'));
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
