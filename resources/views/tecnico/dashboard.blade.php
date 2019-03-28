@can('read_tecnico')    
    @extends('layouts.appdashboard')
    @section('title', 'Dashboard')
    @section('content')    
    
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Painel de Controle</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

   
    <div class="col-lg-12 col-xs-12">
      @include('layouts.error')
    </div>


    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        

        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3 class="text-center">Ticket</h3>

              <p class="text-center">Novo</p>
            </div>
            <a href="{{url('clients/create')}}">
              <div class="icon">
                <i class="fa fa-ticket"></i>
              </div>
            </a>
            <a href="{{url('clients/create')}}" class="small-box-footer">Novo Ticket <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->  

        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3 class="text-center">Livro</h3>

              <p class="text-center">Novo</p>
            </div>
            <a href="{{url('livros/'.$setor->name.'/create')}}">
              <div class="icon">
                <i class="fa fa-book"></i>
              </div>
            </a>
            <a href="{{url('livros/'.$setor->name.'/create')}}" class="small-box-footer">Novo Livro <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3 class="text-center">E<span style="font-size: 17px;">quipamentos</span></h3>

              <p class="text-center">Situação</p>
            </div>
            <a href="{{url('equipamentos/dashboard')}}">
              <div class="icon">
                <i class="fa fa-wrench"></i>
              </div>
            </a>
            <a href="{{url('equipamentos/dashboard')}}" class="small-box-footer">Mais Informações <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3 class="text-center">{{$cont_aloc}}</h3>

              <p class="text-center">Não Alocados</p>
            </div>
            <a href="{{url('tecnicos/'.$setor->name.'/alocar')}}">
              <div class="icon">                
                    <i class="fa fa-ticket"></i>                
              </div>
            </a>
            <a href="{{url('tecnicos/'.$setor->name.'/alocar')}}" class="small-box-footer">Visualizar Tickets <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->


         <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3 class="text-center">{{$qtd_tick_aber}}</h3>

              <p class="text-center">Tickets Aberto(s)</p>
            </div>
            <a href="{{url('tecnicos/'.$setor->name.'/tickets/1/status')}}">
              <div class="icon">                
                    <i class="fa fa-ticket"></i>                
              </div>
            </a>
            <a href="{{url('tecnicos/'.$setor->name.'/tickets/1/status')}}" class="small-box-footer">Visualizar Tickets <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->


        <div class="col-lg-2 col-xs-2">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3 class="text-center">{{$qtd_tick_fech}}</h3>

              <p class="text-center">Tickets Fechado(s)</p>
            </div>
            <a href="{{url('tecnicos/'.$setor->name.'/tickets/0/status')}}">
              <div class="icon">
                <i class="fa fa-ticket"></i>
              </div>
            </a>
            <a href="{{url('tecnicos/'.$setor->name.'/tickets/0/status')}}" class="small-box-footer">Visualizar Tickets<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->

      </div>
      <!-- /.row -->
      <!-- Main row -->     

   
      <!-- Info boxes -->
      <div class="row">
        

        @foreach($tickets as $ticket)

        <!-- Pessima pratica - melhorar -->
        @php
            unset($prontuario_tmp);
            $prontuario_tmp[] = $prontuarios[$ticket->id];
        @endphp


       <div class="col-md-4">
          <!-- DIRECT CHAT PRIMARY -->
          <!--
          0   =>  "Crítico - Emergência (resolver imediatamente)",
          1   =>  "Alto - Urgência (resolver o mais rápido possível)",
          2   =>  "Médio - Intermediária (avaliar situação)",
          3   =>  "Baixo - Rotineiro ou Planejado",
          4   =>  "Nenhum",
          -->
          @switch($ticket->rotulo)
              @case(0)
                  <div class="box box-danger direct-chat direct-chat-primary collapsed-box">
              @break
              @case(1)
                  <div class="box box-warning direct-chat direct-chat-primary collapsed-box">
              @break
              @case(2)
                  <div class="box box-info direct-chat direct-chat-primary collapsed-box">
              @break
              @case(3)
                  <div class="box box-default direct-chat direct-chat-primary collapsed-box">
              @break
              @case(4)
                  <div class="box box-primary direct-chat direct-chat-primary collapsed-box">                  
              @break
          @endswitch         


            <div class="box-header with-border">
              <h3 class="box-title">
                <a href="{{url('tecnicos/'.$setor->name.'/'.$ticket->id.'/show')}}" class="text-black" style="font-size: 25px;">
                  {{ str_limit($ticket->titulo, $limit = 20, $end = '...') }}
                </a></h3><br>
              <a href="{{url('tecnicos/'.$setor->name.'/'.$ticket->id.'/show')}}">Ticket {{$ticket->id}} Nº <b>{{$ticket->protocolo}}</b></a><br>
              <small>Aberto há <b>{{floor((strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', strtotime($ticket->created_at)))) / (60 * 60 * 24))}} dia(s)</b></small><br>

              @foreach($prontuario_tmp as $prontuario)
                @if($prontuario['descricao'])

                  <small>Última ação há <b>{{floor((strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', strtotime($prontuario['created_at'])))) / (60 * 60 * 24))}} dia(s)</b></small><br>

                @else
                  <small>Nenhuma ação.</small><br>
                @endif
              @endforeach

              <!--
              0   =>  "Crítico - Emergência (resolver imediatamente)",
              1   =>  "Alto - Urgência (resolver o mais rápido possível)",
              2   =>  "Médio - Intermediária (avaliar situação)",
              3   =>  "Baixo - Rotineiro ou Planejado",
              4   =>  "Nenhum",
              -->
              <div class="box-tools pull-right">
                @switch($ticket->rotulo)
                    @case(0)
                        <span data-toggle="tooltip" title="Crítico" class="badge bg-red">Crítico</span>
                    @break
                    @case(1)
                        <span data-toggle="tooltip" title="Alto" class="badge bg-yellow">Alto</span>
                    @break
                    @case(2)
                        <span data-toggle="tooltip" title="Médio" class="badge bg-purple">Médio</span>
                    @break
                    @case(3)
                        <span data-toggle="tooltip" title="Baixo" class="badge bg-navy">Baixo</span>
                    @break
                    @case(4)
                        <span data-toggle="tooltip" title="Nenhum" class="badge bg-blue">Nenhum</span>
                    @break
                @endswitch
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                </button>
              </div>


            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">
                <!-- Message. Default to the left -->

                
                @foreach($prontuario_tmp as $prontuario)
                  @if($prontuario['descricao'])
                    <div class="direct-chat-msg">
                    <div class="direct-chat-info clearfix">
                      <!--<span class="direct-chat-name pull-left">{{$prontuario['user_id']}}</span>-->
                      <span class="direct-chat-timestamp pull-right">{{date('d/m/Y H:i:s', strtotime($prontuario['created_at']))}}</span>
                    </div>
                    <!-- /.direct-chat-info -->
                    <img class="direct-chat-img" src="{{ asset('img/default-user-image.png') }}" alt="message user image">
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text">
                      {!! html_entity_decode($prontuario['descricao']) !!}
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <!-- /.direct-chat-msg -->
                @else


                @endif


                @endforeach


              </div>
              <!--/.direct-chat-messages-->

           
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <a href="{{url('tecnicos/'.$setor->name.'/'.$ticket->id.'/show')}}" class="btn btn-success"><i class="fa fa-plus"></i> Mais Informações</a>
              <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/encerrar"  style="float: right;" class="btn btn-danger btn-md"><i class="fa fa-times-circle"></i> Encerrar Ticket</a>            
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>
        <!-- /.col -->        

        @endforeach        
        
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-12">         

          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Últimos Livros</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                    <th>ID</th>
                    <th>Protocolo</th>
                    <th>Início do Serviço</th>
                    <th>Término do Serviço</th> 
                    <th>Responsável</th>
                    <th>Status</th>
                    <th>Autenticação</th>
                  </thead>
                  <tbody>
                  @foreach($livros as $livro)
                  <tr>
                    <td>{{$livro->id}}</td>
                    <td><a href="{{URL::to('livros')}}/{{$setor->name}}/{{$livro->id}}/show">{{str_replace('/'.$setor->name,'', $livro->protocolo)}}</a></td>
                    <td><a href="{{URL::to('livros')}}/{{$setor->name}}/{{$livro->id}}/show">
                    {{date('d/m/Y H:i:s', strtotime($livro->inicio))}}
                    {{$week[date('l', strtotime($livro->inicio))]}}</a>
                    </td>
                    <td><a href="{{URL::to('livros')}}/{{$setor->name}}/{{$livro->id}}/show">
                    {{date('d/m/Y H:i:s', strtotime($livro->fim))}}
                    {{$week[date('l', strtotime($livro->fim))]}}
                    </a>
                    </td>                  
                    <td><a href="{{URL::to('livros')}}/{{$setor->name}}/{{$livro->id}}/show">{{$livro->users->name}}</a></td>
                    <td>
                        <a href="{{URL::to('livros')}}/{{$livro->id}}">
                            <!--
                            0  => "Fechado",
                            1  => "Aberto",  
                            -->
                            @switch($livro->status)
                                @case(1)
                                    <span class="btn btn-success btn-xs">Aprovado</span>
                                    @break                                                               
                                @default
                                    <span class="btn btn-warning btn-xs">Aberto</span>
                            @endswitch
                        </a>
                    </td>
                    <td><a href="{{URL::to('livros')}}/{{$setor->name}}/{{$livro->id}}/show">{{$livro->autenticacao}}</a></td>
                </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <a href="{{URL::to('livros')}}/{{$setor->name}}/create" class="btn btn-sm btn-info btn-flat pull-left">Novo Livro</a>
              <a href="{{URL::to('livros')}}/{{$setor->name}}" class="btn btn-sm btn-default btn-flat pull-right">Visualizar todos os Livros</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <div class="col-md-8">
              <!-- USERS LIST -->
              <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">Equipe {{$setor->label}}</h3>

                  <div class="box-tools pull-right">
                    <span class="label label-danger">{{$equipe_qtd}} Alocado(s)</span>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                  <ul class="users-list clearfix">
                    @foreach($equipe as $membro)
                    <li>
                      <img src="{{asset('img/default-user-image.png')}}" width="50px" height="50px" alt="User Image">
                        <a class="users-list-name" href="#">{{$membro->name}}</a>
                      <span class="users-list-date">{{strtoupper($membro->cargo)}}</span>
                    </li>
                    @endforeach
                    
                  </ul>
                  <!-- /.users-list -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                  <a href="javascript:void(0)" class="uppercase">Todos</a>
                </div>
                <!-- /.box-footer -->
              </div>
              <!--/.box -->
            </div>
            <!-- /.col -->

     
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    @endsection
@endcan
