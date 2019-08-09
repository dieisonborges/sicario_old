@can('read_automacao')    
    @extends('layouts.appdashboard')
    @section('title', 'Dashboard')
    @section('content')    
    
    <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <small>Automação
        <small>Painel de Controle</small></small>
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



      <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-road"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Controle</span>
              <span class="info-box-number">Luzes de Pista</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    Situação Atual: 
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->      


        <div class="col-md-2 col-sm-2 col-xs-12">

          <div class="info-box">
            <a href="{{url('automacao/comando/brilho1')}}">
              <span class="info-box-icon bg-aqua"><i class="fa fa-road"></i></span>
            </a>

            <div class="info-box-content">
              <span class="info-box-text">Acionar</span>
              <span class="info-box-number">Brilho 1</span>
              <i class="fa fa-star text-yellow"></i>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-2 col-sm-2 col-xs-12">
          <div class="info-box">
            <a href="{{url('automacao/comando/brilho2')}}">
              <span class="info-box-icon bg-aqua"><i class="fa fa-road"></i></span>
            </a>

            <div class="info-box-content">
              <span class="info-box-text">Acionar</span>
              <span class="info-box-number">Brilho 2</span>
              <i class="fa fa-star text-yellow"></i>
              <i class="fa fa-star text-yellow"></i>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-2 col-sm-2 col-xs-12">
          <div class="info-box">
            <a href="{{url('automacao/comando/brilho3')}}">
              <span class="info-box-icon bg-aqua"><i class="fa fa-road"></i></span>
            </a>

            <div class="info-box-content">
              <span class="info-box-text">Acionar</span>
              <span class="info-box-number">Brilho 3</span>
              <i class="fa fa-star text-yellow"></i>
              <i class="fa fa-star text-yellow"></i>
              <i class="fa fa-star text-yellow"></i>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-2 col-sm-2 col-xs-12">
          <div class="info-box">
            <a href="{{url('automacao/comando/brilhooff')}}">
              <span class="info-box-icon bg-red"><i class="fa fa-lightbulb-o"></i></span>
            </a>

            <div class="info-box-content">
              <span class="info-box-text">Desligar</span>
              <span class="info-box-number">Luzes</span>
              <i class="fa fa-toggle-off"></i>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <hr class="col-md-12">

        

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-blue">
            <span class="info-box-icon"><i class="fa fa-adjust"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Controle</span>
              <span class="info-box-number">Farol Rotativo</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    Situação Atual: 
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->   

        <div class="col-md-2 col-sm-2 col-xs-12">
          <div class="info-box">
            <a href="{{url('automacao/comando/farolon')}}">
              <span class="info-box-icon bg-aqua"><i class="fa fa-adjust"></i></span>
            </a>

            <div class="info-box-content">
              <span class="info-box-text">Acionar</span>
              <span class="info-box-number">Farol</span>
              <i class="fa fa-toggle-on"></i>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-2 col-sm-2 col-xs-12">
          <div class="info-box">
            <a href="{{url('automacao/comando/faroloff')}}">
              <span class="info-box-icon bg-red"><i class="fa fa-adjust"></i></span>
            </a>

            <div class="info-box-content">
              <span class="info-box-text">Desligar</span>
              <span class="info-box-number">Farol</span>
              <i class="fa fa-toggle-off"></i>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>


        

      </div>
      <!-- /.row -->
      <!-- Main row -->     

   
      

     
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    @endsection
@endcan
