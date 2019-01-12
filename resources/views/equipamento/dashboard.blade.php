@can('read_equipamento')    
    @extends('layouts.appdashboard')
    @section('title', 'Dashboard')
    @section('content')    
    
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Equipamentos</small>
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
      <div class="row">

        <!-- Main content -->
        <section class="content">
          
          <!-- Default box -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Equipamentos com Inoperância</h3>              
            </div>
            <div class="box-body">   

              @foreach($equipamentos_inops as $equipamentos_inop)

              <div class="col-md-6">
                <div class="info-box bg-red">
                  <span class="info-box-icon">                    
                    <span style="font-size: 80%;">
                      <i class="ion ion-nuclear"></i>                      
                    </span>
                  </span>

                  <div class="info-box-content">
                    <span class="info-box-text">{{$sistema_nome[$equipamentos_inop->sistema_id]}}</span>
                    <span class="info-box-number">{{str_limit(($equipamentos_inop->nome), 10)}} | <small>{{str_limit(($equipamentos_inop->descricao), 30)}}</small></span>

                    <div class="progress">
                      <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                          <a class="btn btn-info btn-xs" href="{{url('tecnicos/'.$setor->name.'/tickets/'.$equipamentos_inop->id.'/1/equipamento')}}" style="color: white;"> <span class="fa fa-ticket"></span> Ver Tickets </a>
                          <a class="btn btn-info btn-xs" href="{{url('equipamentos/'.$equipamentos_inop->id)}}" style="color: white;"> <span class="fa fa-wrench"></span> Ver Equipamento </a>
                    </span>
                  </div>
                  <!-- /.info-box-content -->
                </div>
              </div>
              <!-- /.col-md-4 -->

              @endforeach




            </div>
            <!-- /.box-body -->
            

            <!-- /.box-footer-->
          </div>
          <!-- /.box -->
        </section>
        <!-- /.content -->

        

        


      </div>

      <h2 class="page-header">Todos os Sistemas </h2>

      <div class="row">


        @foreach($sistemas as $sistema)


       
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            @if(($sistema->equipamentos()->where('equipamentos.status', '0')->count())>0)
            <div class="widget-user-header bg-red">
            @else
            <div class="widget-user-header bg-blue">
            @endif
              <h3 class="widget-user-username text-center">{{$sistema->nome}}</h3>
            </div>

            <div class="widget-user-image">
              <img class="img-circle" src="../img/equipamentos/sagitario-128x128.jpg" alt="User Avatar" alt="{{$sistema->descricao}}">
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-12">
                  <br>
                  <h5 class="widget-user-desc text-center">{{str_limit($sistema->descricao, 40)}}</h5>

                </div>

                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{$sistema_ticket_qtd_abertos[$sistema->id]}}</h5>
                    <span class="description-text">Tickets Abertos</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-header">{{$sistema_ticket_qtd_fechados[$sistema->id]}}</h5>
                    <span class="description-text">Tickets Fechados</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li><a href="{{url('equipamentos/dashboard/'.$sistema->id)}}">Equipamentos (Total)<span class="pull-right badge bg-blue">{{$sistema->equipamentos()->count()}}</span></a></li>
                <li><a href="{{url('equipamentos/dashboard/'.$sistema->id)}}">Equipamentos Inoperantes <span class="pull-right badge bg-red">{{$sistema->equipamentos()->where('equipamentos.status', '0')->count()}}</span></a></li>
                <li><a href="{{url('equipamentos/dashboard/'.$sistema->id)}}">Equipamentos Operacionais <span class="pull-right badge bg-green">{{$sistema->equipamentos()->where('equipamentos.status', '1')->count()}}</span></a></li>
              </ul>
            </div>           

            @if((($sistema->equipamentos()->where('equipamentos.status', '0')->count())==0)&&(($sistema_ticket_qtd_abertos[$sistema->id])>0))
            <div class="box-footer"> 
              <div class="callout callout-warning">
                <h4>Inconsistência Detectada!</h4>
                <p>Existem tickets abertos para o sistema {{$sistema->nome}}, porém não foi modificado o status de nenhum equipamento para Inoperante.</p>
              </div>
            </div>
            @endif

            @if((($sistema->equipamentos()->where('equipamentos.status', '0')->count())>0)&&(($sistema_ticket_qtd_abertos[$sistema->id])==0))
            <div class="box-footer"> 
              <div class="callout callout-warning">
                <h4>Inconsistência Detectada!</h4>
                <p>Existem inoperâncias para o sistema {{$sistema->nome}}, porém não existe nenhum ticket aberto.</p>
              </div>
            </div>
            @endif

          </div>
          <!-- /.widget-user -->
        </div>
        <!-- /.col -->
        

        @endforeach 








      </div>
      <!-- /.row -->

      


      
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    @endsection
@endcan
