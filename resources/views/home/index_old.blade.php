@extends('layouts.app')

@section('content')


    <div class="row">
            <div class="col-md-12">

                <section class="content-header">
                      <h1>
                        e-Cardume
                        <small>Painel de Controle</small>
                      </h1>
                      <ol class="breadcrumb">
                        <li><a href="{{url('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                      </ol>
                </section>
                
            </div>

        <span style="width: 100%; min-height: 80px; display: block;"></span>

        <div class="col-md-12"> 

            @if (Auth::user()->status)
            <!-- ********************** Administrador ***************** -->
            
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>Administrador</h3>
                        <p>Módulo</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-cogs"></i>
                    </div>
                    <a href="{{ url('users/') }}" class="small-box-footer">Abrir <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            @endif


            <!-- ********************** eCardume VIP ***************** -->
            <div class="col-lg-4 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>Cardume VIP</h3>
                        <p>Módulo</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="{{ url('produtos/') }}" class="small-box-footer">Abrir <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        
        </div>
    </div>


@endsection
