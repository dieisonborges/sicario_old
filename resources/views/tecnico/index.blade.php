@can('read_tecnico')    
    @extends('layouts.app')
    @section('title', 'Tickets')
    @section('content')    
    <h1>Tickets</h1>



        <div class="col-md-12"> 

            <form method="POST" enctype="multipart/form-data" action="{{url('tecnicos/'.$setor->name.'/busca')}}">
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
            <h3 class="box-title">{{$setor->label}} <small>Gerência de Tickets</small></h3>

            
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Protocolo</th>
                    <th>Status</th>
                    <th>Usuário</th>
                    <th>Titulo</th>
                    <th>Criado em:</th>
                    <th>Equipamento</th>
                    <th>Rótulo</th>
                    <th>Tipo</th>
                    <th>Setor de <br> Trabalho</th>
                    <th>Editar</th>
                </tr>
                @forelse ($tickets as $ticket)
                <tr>
                    <td>{{$ticket->id}}</td>
                    <td><a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/show">{{$ticket->protocolo}}</a></td>
                    <td>
                        <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/show">
                            <!--
                            0  => "Fechado",
                            1  => "Aberto",  
                            -->
                            @switch($ticket->status)
                                @case(0)
                                    <span class="btn btn-success btn-xs">Fechado</span>
                                    @break                                                               
                                @default
                                    <span class="btn btn-warning btn-xs">Aberto</span>
                            @endswitch
                        </a>
                    </td>
                    <td><a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/show">{{$ticket->users->name}}</a></td>
                    <td><a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/show">{{$ticket->titulo}}</a></td>
                    <td><a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/show">{{date('d/m/Y H:i:s', strtotime($ticket->created_at))}}</a></td>
                    <td>
                        <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/show">{{$ticket->equipamentos['nome']}}</a></td>
                    <td>
                        <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/show">
                            <!--
                            0   =>  "Crítico - Emergência (resolver imediatamente)",
                            1   =>  "Alto - Urgência (resolver o mais rápido possível)",
                            2   =>  "Médio - Intermediária (avaliar situação)",
                            3   =>  "Baixo - Rotineiro ou Planejado",
                            -->
                            @switch($ticket->rotulo)
                                @case(0)
                                    <span class="btn btn-danger btn-xs">Crítico</span>
                                    @break
                                @case(1)
                                    <span class="btn btn-warning btn-xs">Alto</span>
                                    @break
                                @case(2)
                                    <span class="btn btn-info btn-xs">Médio</span>
                                    @break
                                @case(3)
                                    <span class="btn btn-xs">Baixo</span>
                                    @break                            

                            @endswitch
                        </a>
                    </td>

                    <td>
                        <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/show">
                            <!--
                            0  => "Técnico",
                            1  => "Administrativo",  
                            -->
                            @switch($ticket->tipo)
                                @case(0)
                                    <span>Técnico</span>
                                    @break
                                @case(1)
                                    <span>Administrativo</span>
                                    @break                                
                                @default
                                    <span>Nenhum</span>
                            @endswitch
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-primary btn-xs" href="{{URL::to('tecnicos/'.$setor->name.'/'.$ticket->id.'/setors')}}"><i class="fa fa-group"></i> Setor</a>
                    </td>

                    @if(($ticket->status)!=0)
                    <td>
                        <a class="btn btn-warning btn-xs" href="{{URL::to('tecnicos/'.$setor->name.'/'.$ticket->id.'/edit')}}"><i class="fa fa-edit"></i> Editar</a>
                    </td>
                    @else
                    <td>
                        <span class="btn btn-success btn-xs"> Fechado </span>
                    </td>
                    @endif
                    
                </tr>                
                @empty
                    
                @endforelse            
                
            </table>
        </div>
        <!-- /.box-body -->

        {{$tickets->links()}}

    @endsection
@endcan
