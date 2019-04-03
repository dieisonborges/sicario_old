@can('read_tecnico')    
    @extends('layouts.app')
    @section('title', 'Super Busca')
    @section('content')    
    <h1>Super Busca SICARIO</h1>

    <div class="box-body col-md-12">              
          <div class="callout callout-info">
            <h5>Meu Setor: <b>{{$setor->label}}</b></h5>
            <h5>Busca: <b>{{$buscar}}</b></h5>
          </div>
    </div> 

        <div class="col-md-12 form-group"> 

            <form method="POST" enctype="multipart/form-data" action="{{url('tecnicos/'.$setor->name.'/superBusca')}}">
                @csrf
                <div class="input-group input-group-lg">            
                    <input type="text" class="form-control" id="busca" name="busca" value="{{$buscar}}" placeholder="Procurar..." >
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-info btn-flat">Buscar</button>
                        </span>

                </div>
            </form>
     
        </div> 

        <br><br><br>

        <div class="box-header">
            <h3 class="box-title">Todos <small>os Tickets do Sistema</small></h3>            
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Protocolo</th>
                    <th>Status</th>
                    <th>Titulo</th>
                    <th>Criado em:</th>
                    <th>Rótulo</th>
                    <th>Tipo</th>
                    <th>Setores <br>com Acesso</th>
                    <th>Ver</th>
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
                    <td><a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/show">{{$ticket->titulo}}</a></td>
                    <td><a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/show">{{date('d/m/Y H:i:s', strtotime($ticket->created_at))}}</a></td>
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
                        @foreach($all_ticket_setors as $all_setor)
                            @if(($all_setor->ticket_id)==$ticket->id)
                                @if(($setor->id)==($all_setor->setor_id))
                                    <span class="btn btn-primary btn-xs">{{$all_setor->label}}</span>
                                @else
                                    <span class="btn btn-danger btn-xs">{{$all_setor->label}}</span>
                                @endif                        
                            @endif
                        @endforeach  
                        @php
                            $all_setor=null;
                        @endphp                  
                    </td>

                    <td>
                        <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/show" class="btn btn-success btn-xs"> <span class="fa fa-eye"></span> Visualizar </a>
                    </td>
                    
                </tr>                
                @empty

                <tr>
                    <td>
                        <span class="btn btn-warning">
                            <i class="fa fa-frown-o"></i>
                             Nenhum Resultado Para Esse Critério.
                        </span>
                    </td>
                    
                </tr>
                    
                @endforelse            
                
            </table>
        </div>
        <!-- /.box-body -->

        <span class="btn btn-primary btn-xs">*Limite 100</span>

        <br><br><br>

        
        <div class="box-header">
            <h3 class="box-title">Todos <small>os Tickets do Sistema com Ações</small></h3>            
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Protocolo</th>
                    <th>Status</th>
                    <th>Titulo</th>
                    <th>Criado em:</th>
                    <th>Rótulo</th>
                    <th>Tipo</th>
                    <th>Setores <br>com Acesso</th>
                    <th>Ver</th>
                </tr>
                @forelse ($tickets_acoes as $ticket_acoes)
                <tr>
                    <td>{{$ticket_acoes->id}}</td>
                    <td><a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket_acoes->id}}/show">{{$ticket_acoes->protocolo}}</a></td>
                    <td>
                        <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket_acoes->id}}/show">
                            <!--
                            0  => "Fechado",
                            1  => "Aberto",  
                            -->
                            @switch($ticket_acoes->status)
                                @case(0)
                                    <span class="btn btn-success btn-xs">Fechado</span>
                                    @break                                                               
                                @default
                                    <span class="btn btn-warning btn-xs">Aberto</span>
                            @endswitch
                        </a>
                    </td>
                    <td><a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket_acoes->id}}/show">{{$ticket_acoes->titulo}}</a></td>
                    <td><a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket_acoes->id}}/show">{{date('d/m/Y H:i:s', strtotime($ticket_acoes->created_at))}}</a></td>
                    <td>
                    
                        <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket_acoes->id}}/show">
                            <!--
                            0   =>  "Crítico - Emergência (resolver imediatamente)",
                            1   =>  "Alto - Urgência (resolver o mais rápido possível)",
                            2   =>  "Médio - Intermediária (avaliar situação)",
                            3   =>  "Baixo - Rotineiro ou Planejado",
                            -->
                            @switch($ticket_acoes->rotulo)
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
                        <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket_acoes->id}}/show">
                            <!--
                            0  => "Técnico",
                            1  => "Administrativo",  
                            -->
                            @switch($ticket_acoes->tipo)
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
                        @foreach($all_ticket_setors as $all_setor)
                            @if(($all_setor->ticket_id)==$ticket_acoes->id)
                                @if(($setor->id)==($all_setor->setor_id))
                                    <span class="btn btn-primary btn-xs">{{$all_setor->label}}</span>
                                @else
                                    <span class="btn btn-danger btn-xs">{{$all_setor->label}}</span>
                                @endif                        
                            @endif
                        @endforeach  
                        @php
                            $all_setor=null;
                        @endphp                  
                    </td>

                    <td>
                        <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket_acoes->id}}/show" class="btn btn-success btn-xs"> <span class="fa fa-eye"></span> Visualizar </a>
                    </td>
                    
                </tr>                
                @empty
                <tr>
                    <td>
                        <span class="btn btn-warning">
                            <i class="fa fa-frown-o"></i>
                             Nenhum Resultado Para Esse Critério.
                        </span>
                    </td>
                    
                </tr> 
                    
                @endforelse            
                
            </table>
        </div>
        <!-- /.box-body -->

        <span class="btn btn-primary btn-xs">*Limite 100</span>

        <br><br><br>

        
        <div class="box-header">
            <h3 class="box-title">Todos <small>os Tutoriais do Sistema</small></h3>            
        </div>
        <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Palavras Chave</th>
                <th>Setores <br>com Acesso</th>
                <th>Ver</th>
            </tr>
            @forelse ($tutorials as $tutorial)
            <tr>
                <td><a href="{{URL::to('tutorials/'.$setor->name.'/'.$tutorial->id.'/show')}}">{{$tutorial->id}}</a></td>
                <td><a href="{{URL::to('tutorials/'.$setor->name.'/'.$tutorial->id.'/show')}}">{{ str_limit($tutorial->titulo, $limit = 40, $end = '...') }}</a></td>
                <td><a href="{{URL::to('tutorials/'.$setor->name.'/'.$tutorial->id.'/show')}}">{{$tutorial->palavras_chave}}</a></td>
                <!--<td><a href="{{URL::to('tutorials/'.$setor->name.'/'.$tutorial->id.'/show')}}">{{ str_limit($tutorial->conteudo, $limit = 40, $end = '...') }}</a></td>-->
                <td>
                    @foreach($all_tutorial_setors as $all_setor)
                        @if(($all_setor->tutorial_id)==$tutorial->id)
                            @if(($setor->id)==($all_setor->setor_id))
                                <span class="btn btn-primary btn-xs">{{$all_setor->label}}</span>
                            @else
                                <span class="btn btn-danger btn-xs">{{$all_setor->label}}</span>
                            @endif                        
                        @endif
                    @endforeach
                    @php
                        $all_setor=null;
                    @endphp                    
                </td>
                <td>
                    <a class="btn btn-success btn-xs" href="{{URL::to('tutorials/'.$setor->name.'/'.$tutorial->id.'/show')}}"><i class="fa fa-eye"></i> Visualizar</a>
                </td>
                
            </tr>                
            @empty

            <tr>
                <td>
                    <span class="btn btn-warning">
                        <i class="fa fa-frown-o"></i>
                         Nenhum Resultado Para Esse Critério.
                    </span>
                </td>
                
            </tr>
                
            @endforelse            
            
        </table>
    </div>
    <!-- /.box-body -->
    <span class="btn btn-primary btn-xs">*Limite 100</span>

    @endsection
@endcan
