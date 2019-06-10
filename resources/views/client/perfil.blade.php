@extends('layouts.app')
@section('title', $user->name)
@section('content')
	<h1>
		<i class="fa fa-star"></i>
        Perfil e Score
        <small>de {{$user->name}}</small>
    </h1>
	<div class="row">


		
		    <div class="box-body col-md-4">              
              <div class="callout callout-info">
              	<h5>ID: <b> {{$user->id}}</b></h5>
                <h5>Função: <b> {{$user->cargo}}</b></h5>
                <h5>Nome Principal: <b> {{$user->name_principal}}</b></h5>
                <h5>Nome Completo: <b> {{$user->name}}</b></h5>
                <h5>e-Mail: <b>{{$user->email}}</b></h5>
                <h5>CPF: <b> {{$user->cpf}}</b></h5>
                <h5>Telefone: <b> {{$user->phone_number}}</b></h5>
                <h5>Desde: <b> {{date('d/m/Y H:i:s', strtotime($user->created_at))}}</b></h5> 
                
              </div>
        </div>

        <div class="box-body col-md-2">              
              
            @if($imagem)  
                <img src="{{ url('storage/'.$imagem->dir.'/'.$imagem->link) }}" width="100%">
            @else
                <img src="{{ asset('img/default-user-image.png') }}" width="100%">
            @endif
           

            <a href="{{URL::to('clients')}}/imagem" class="btn btn-primary btn-xs"><i class="fa fa-image"></i> Alterar Imagem</a>

        </div>


        

	</div>

	
@endsection