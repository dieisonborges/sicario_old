@can('update_ticket')  
    @extends('layouts.app')
    @section('title', 'Regras')
    @section('content')

    <h1>Setor(es) de Trabalho Associados ao Ticket <small>{{$ticket->protocolo}}</small></h1>
        <div class="box-body col-md-6">              
              <div class="callout callout-info">
                <h5>Usuário: <b>{{$ticket->users->name}}</b></h5>
                <h5>Número de Protocolo: <b>{{$ticket->protocolo}}</b></h5>
                <h5>Aberto em: <b>{{date('d/m/Y H:i:s', strtotime($ticket->created_at))}}</b></h5>
                <h5>Título: <b>{{$ticket->titulo}}</b></h5>
              </div>
        </div>


        <div class="col-md-12">  
            <form method="POST" action="{{action('TicketController@setorUpdate')}}">
                @csrf
                <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                <label>Adicionar Setor:</label>
                <select name="setor_id">
                    @forelse ($all_setors as $all_setor)
                        <option value="{{$all_setor->id}}">
                            {{$all_setor->name}} | {{$all_setor->label}}
                        </option>
                    @empty
                        <option>Nenhuma Opção</option>     
                    @endforelse
                </select>
                <label>Ao usuário:</label>
                <span>{{$ticket->protocolo}} | <small>{{$ticket->id}}</small></span>
                <input class="btn btn-success btn-sm" type="submit" value="Adicionar">
            </form>
        </div>

        
        <div class="box-header col-md-12">
            <h3 class="box-title">Setores Incluídos: </h3>        
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding col-md-12">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Nome (Name)</th>
                    <th>Rótulo (Label)</th>
                    <th>Excluir</th>
                </tr>


                @forelse ($setors as $setor)
                <tr>
                    <td>{{$setor->id}}</td>
                    <td>{{$setor->name}}</td>
                    <td>{{$setor->label}}</td>

                    
                    
                    <td>

                        <form method="POST" action="{{action('TicketController@setorDestroy')}}" id="formDelete{{$setor->id}}">
                            @csrf
                            <input type="hidden" name="setor_id" value="{{$setor->id}}">
                            <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                            <!--<button class="btn btn-danger btn-xs" >Excluir</button>-->
                            <!--<input type="submit" name="Excluir">-->

                            <a href="javascript:confirmDelete{{$setor->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Excluir</a>
                        </form> 

                        <script>
                           function confirmDelete{{$setor->id}}() {

                            var result = confirm('Tem certeza que deseja excluir?');

                            if (result) {
                                    document.getElementById("formDelete{{$setor->id}}").submit();
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
       

    @endsection
@endcan
