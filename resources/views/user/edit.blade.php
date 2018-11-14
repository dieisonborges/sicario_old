@can('update_user')  
	@extends('layouts.app')
	@section('title', 'Editar Usuário')
	@section('content')
			<h1>
		        Editar Usuário
		        <small>{{$user->nome}}</small>
		    </h1>
			

			<form method="POST" enctype="multipart/form-data" action="{{action('UserController@update',$id)}}">
				@csrf
				<input type="hidden" name="_method" value="PATCH">
				<div class="form-group mb-12">
				    <label for="name">Nome</label>
				    <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" placeholder="Digite o nome completo..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="cargo">Cargo/Posto/Graduação/Formação</label>
				    <input type="text" class="form-control" id="cargo" name="cargo" value="{{$user->cargo}}" placeholder="Digite o Cargo, Posto, Graduação ou Formação..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="email">E-mail</label>
				    <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" placeholder="Digite o E-mail..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="cpf">Cpf</label>
				    <input type="text" class="form-control" id="cpf" name="cpf" value="{{$user->cpf}}" placeholder="Digite o CPF..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="telefone">Celular com DDD</label>
				    <input type="text" class="form-control" id="telefone" name="telefone" value="{{$user->telefone}}" placeholder="Digite o Celular..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="status">Status (1 - Ativo | 0 - Inativo)</label>
				    <input type="hidden" name="status" value="{{$user->status}}" required>
				    <input type="number" class="form-control" id="status_visible" name="status_visible" value="{{$user->status}}" placeholder="Digite o status..." disabled="disabled" required>
				    @if ($user->status)
	                    <span class="label label-success">ATIVO</span>                        
	                @else
	                    <span class="label label-danger">INATIVO</span>
	                @endif
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="login">Login (Maior que 15 BLOQUEADO)</label>
				    <input type="number" class="form-control" id="login" name="login" value="{{$user->login}}" placeholder="Digite o login..." required>
				    @if (($user->login)<=15)
	                    <span class="label label-success">LIBERADO</span>
	                @else
	                    <span class="label label-danger">BLOQUEADO</span>
	                @endif
			 	</div>
			 	

			 	<div>
			 		<hr>
			 	</div>

			 	<button type="submit" class="btn btn-primary">Atualizar</button>
			</form>
	@endsection
@endcan