@can('read_equipamento')    
    @extends('layouts.appdashboard')
    @section('title', 'Dashboard')
    @section('content')    
    
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$sistema->nome}}
        <small>Dashboard</small>
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

            <h2 class="page-header">{{$sistema->descricao}} </h2>

      <div class="row">

        @foreach($equipamentos as $equipamento)

        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            @if($equipamento->status==0)
            <div class="widget-user-header bg-red">
            @else
            <div class="widget-user-header bg-green">
            @endif
              <a href="{{url('equipamentos/1/edit')}}" class="btn btn-primary btn-sm text-right" style="float: right;">
                  <span class="fa fa-edit"></span>
              </a>
              <div class="widget-user-image">
                <img class="img-circle" src="../../img/equipamentos/sagitario-128x128.jpg" alt="User Avatar">
              </div>
              <!-- /.widget-user-image -->
              <h3 class="widget-user-username"><b>{{$equipamento->nome}}</b></h3>
              <h5 class="widget-user-desc">{{$equipamento->descricao}}</h3>
              @if($equipamento->status==0)
                <h5 class="widget-user-desc">Status: <b>INOPERÂNCIA</b></h5>
              @else
                <h5 class="widget-user-desc">Status: Operacional</h5>
              @endif           
            </div>
            
            <div class="box-footer no-padding">
              <ul class="nav nav-stacked">
                <li>
                    <a href="{{url('tiop_supervisao/tickets/1/status'.$equipamento->id)}}">
                      Tickets Abertos
                      <span class="fa fa-ticket"></span>
                      <span class="pull-right badge bg-red">--</span>
                    </a>
                </li>
                <li>
                    <a href="{{url('tiop_supervisao/tickets/0/status'.$equipamento->id)}}">
                      Tickets Fechados
                      <span class="fa fa-ticket"></span>
                      <span class="pull-right badge bg-green">--</span>
                    </a>
                </li>
                <!--
                <li>
                    <a href="{{url('equipamentos/documentacao/'.$equipamento->id)}}">
                      Manuais & Documentação
                      <span class="fa fa-book"></span>
                      <span class="pull-right badge bg-blue">31</span>
                    </a>
                </li>
              -->
                <li></li>              
                
              </ul>
              
              <div class="col-md-12 text-center">
                <br>
                @if($equipamento->status==0)
                    <a href="{{url('equipamentos/status/'.$equipamento->id.'/'.'1'.'/'.$sistema->id)}}" class="btn bg-aqua text-white">Restabelecer</a>
                @else
                    <a href="{{url('equipamentos/status/'.$equipamento->id.'/'.'0'.'/'.$sistema->id)}}" class="btn bg-blue text-white">Abrir Inoperância</a>

                @endif
                <br><br>
              </div>              
            </div>
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
