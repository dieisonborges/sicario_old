@can('read_ticket')    
    @extends('layouts.app')
    @section('title', 'Tickets')
    @section('content')    
    <h1>Tickets <a href="{{url('tickets/create')}}" class="btn btn-info btn-lg"><i class="fa fa-plus"> </i> Novo</a>  </h1>



        <div class="col-md-12">	

            <form method="POST" enctype="multipart/form-data" action="{{url('tickets/busca')}}">
                @csrf
                <div class="input-group input-group-lg">			
                    <input type="text" class="form-control" id="busca" name="busca" placeholder="Procurar..." value="{{$buscar}}">
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-info btn-flat">Buscar</button>
                        </span>

                </div>
            </form>
     
        </div> 

        <br><br><br>

        
        <div class="box-header">
            <h3 class="box-title">Gerência de Tickets</h3>
            
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Protocolo</th>
                    <th>Status</th>
                    <th>Usuário</th>
                    <th>Descrição</th>
                    <th>Criado em:</th>
                    <th>Modificado em:</th>
                    <th>Ticket</th>
                    <th>Rótulo</th>
                    <th>Tipo</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
                @forelse ($tickets as $ticket)
                <tr>
                    <td>{{$ticket->id}}</td>
                    <td><a href="{{URL::to('tickets')}}/{{$ticket->id}}">{{$ticket->protocolo}}</a></td>
                    <td><a href="{{URL::to('tickets')}}/{{$ticket->id}}">{{$ticket->status}}</a></td>
                    <td><a href="{{URL::to('tickets')}}/{{$ticket->id}}">{{$ticket->user_id}}</a></td>
                    <td><a href="{{URL::to('tickets')}}/{{$ticket->id}}">{{$ticket->descricao}}</a></td>
                    <td><a href="{{URL::to('tickets')}}/{{$ticket->id}}">{{$ticket->created_at}}</a></td>
                    <td><a href="{{URL::to('tickets')}}/{{$ticket->id}}">{{$ticket->updated_at}}</a></td>
                    <td><a href="{{URL::to('tickets')}}/{{$ticket->id}}">{{$ticket->equipamento_id}}</a></td>   
                    <td><a href="{{URL::to('tickets')}}/{{$ticket->id}}">{{$ticket->rotulo}}</a></td>  
                    <td><a href="{{URL::to('tickets')}}/{{$ticket->id}}">{{$ticket->tipo}}</a></td>                   
                    <td>
                        <a class="btn btn-warning btn-xs" href="{{URL::to('tickets/'.$ticket->id.'/edit')}}"><i class="fa fa-edit"></i> Editar</a>
                    </td>
                    <td>

                        <form method="POST" action="{{action('TicketController@destroy', $ticket->id)}}" id="formDelete{{$ticket->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <!--<button class="btn btn-danger btn-xs" >Excluir</button>-->
                            <!--<input type="submit" name="Excluir">-->

                            <a href="javascript:confirmDelete{{$ticket->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Excluir</a>
                        </form> 

                        <script>
                           function confirmDelete{{$ticket->id}}() {

                            var result = confirm('Tem certeza que deseja excluir?');

                            if (result) {
                                    document.getElementById("formDelete{{$ticket->id}}").submit();
                                } else {
                                    return false;
                                }
                            } 
                        </script>

                    </td>
                </tr>                
                @empty
                    
                @endforelse            
                
            </table>
        </div>
        <!-- /.box-body -->

        {{$tickets->links()}}

    @endsection
@endcan
