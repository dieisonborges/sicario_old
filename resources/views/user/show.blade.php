@can('read_user')  
	@extends('layouts.app')
	@section('title', $user->titulo)
	@section('content')
		<h1>
	        Usuário
	        <small>{{$user->name}}</small>
	    </h1>
		<div class="row">		
			<div class="col-md-6">
				<ul>
					<li><strong>ID: </strong> {{$user->id}}</li>
					<li><strong>Nome: </strong> {{$user->name}}</li>
					<li><strong>Email: </strong> {{$user->email}}</li>
					<li><strong>CPF: </strong> {{$user->cpf}}</li>
					<li><strong>Telefone: </strong> {{$user->telefone}}</li>
					<li>
					@if ($user->status)
	                    <span class="label label-success">ATIVO</span>                        
	                @else
	                    <span class="label label-danger">INATIVO</span>
	                @endif
	            	</li>
	            	<li>
	            	@if (($user->login)<=15)
	                    <span class="label label-success">LIBERADO</span>
	                @else
	                    <span class="label label-danger">BLOQUEADO</span>
	                @endif	
	            	</li>
				</ul>	
			</div>

		</div>
		
		
		<a href="javascript:history.go(-1)">Voltar</a>
	@endsection
@endcan