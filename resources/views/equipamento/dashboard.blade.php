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

            <h2 class="page-header">Sistemas </h2>

      <div class="row">




        @foreach($sistemas as $sistema)


       
        <div class="col-md-4">
          <!-- Widget: user widget style 1 -->
          <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue">
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
                    <h5 class="description-header">--</h5>
                    <span class="description-text">Tickets Abertos</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-6 border-right">
                  <div class="description-block">
                    <h5 class="description-header">--</h5>
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
                <li><a href="{{url('equipamentos/dashboard/'.$sistema->id)}}">Equipamentos (Total)<span class="pull-right badge bg-blue">--</span></a></li>
                <li><a href="#">Equipamentos Inoperantes <span class="pull-right badge bg-red">--</span></a></li>
                <li><a href="#">Equipamentos Operacionais <span class="pull-right badge bg-green">--</span></a></li>
              </ul>
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
