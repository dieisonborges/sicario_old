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
        

        <div class="col-lg-4 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>Ticket</h3>

              <p>Criar Novo Ticket</p>
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

        <div class="col-lg-4 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>Livro</h3>

              <p>Novo Livro de Serviço</p>
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

        <div class="col-lg-4 col-xs-4">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>Equipamentos</h3>

              <p>Verificar situação dos equipamentos</p>
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

        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$cont_aloc}}</h3>

              <p>Tickets sem Setor (Não Alocados)</p>
            </div>
            <a href="{{url('tecnicos/'.$setor->name.'/alocar')}}">
              <div class="icon">                
                    <i class="fa fa-ticket"></i>                
              </div>
            </a>
            <a href="{{url('tecnicos/'.$setor->name.'/alocar')}}" class="small-box-footer">Visualizar <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->


         <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{$qtd_tick_aber}}</h3>

              <p>Tickets Aberto(s)</p>
            </div>
            <a href="{{url('tecnicos/'.$setor->name.'/tickets/1/status')}}">
              <div class="icon">                
                    <i class="fa fa-ticket"></i>                
              </div>
            </a>
            <a href="{{url('tecnicos/'.$setor->name.'/tickets/1/status')}}" class="small-box-footer">Visualizar <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->


        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$qtd_tick_fech}}</h3>

              <p>Tickets Fechado(s)</p>
            </div>
            <a href="{{url('tecnicos/'.$setor->name.'/tickets/0/status')}}">
              <div class="icon">
                <i class="fa fa-ticket"></i>
              </div>
            </a>
            <a href="{{url('tecnicos/'.$setor->name.'/tickets/0/status')}}" class="small-box-footer">Visualizar <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->


    
        
      </div>
      <!-- /.row -->
      <!-- Main row -->     

   
      <!-- Info boxes -->
      <div class="row">
        

        @foreach($tickets as $ticket)
        <div class="col-md-4 col-sm-6 col-xs-12">
          <a href="{{url('tecnicos/'.$setor->name.'/'.$ticket->id.'/show')}}">
            <div class="info-box">
              <!--
              0   =>  "Crítico - Emergência (resolver imediatamente)",
              1   =>  "Alto - Urgência (resolver o mais rápido possível)",
              2   =>  "Médio - Intermediária (avaliar situação)",
              3   =>  "Baixo - Rotineiro ou Planejado",
              4   =>  "Nenhum",
              -->
              @switch($ticket->rotulo)
                  @case(0)
                      <span class="info-box-icon bg-red">
                        <i class="fa fa-ticket"></i>
                      </span>                    
                  @break
                  @case(1)
                      <span class="info-box-icon bg-yellow">
                        <i class="fa fa-ticket"></i>
                      </span>                    
                  @break
                  @case(2)
                      <span class="info-box-icon bg-purple">
                          <i class="fa fa-ticket"></i>
                      </span>
                  @break
                  @case(3)
                      <span class="info-box-icon bg-navy">
                        <i class="fa fa-ticket"></i>
                      </span>
                  @break
                  @case(4)
                      <span class="info-box-icon bg-blue">
                        <i class="fa fa-ticket"></i>
                      </span>
                  @break
              @endswitch

              <div class="info-box-content">
                <span class="info-box-number" style="margin-bottom: 5px;">Ticket nº 
                <b>{{$ticket->protocolo}}</a>
                </b></span>

                <span class="info-box-text"><b>{{$ticket->titulo}}</b></span>                
                <span class="info-box-text">Dias Abertos: 

                  {{
                    floor((strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', strtotime($ticket->created_at)))) / (60 * 60 * 24))
                  }}
                  dia(s)
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->

            </a>
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
                      <img src="{{asset('img/default-user-image.png')}}" width="90px" height="90px" alt="User Image">
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
