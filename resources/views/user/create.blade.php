@can('create_user')  
	@extends('layouts.app')
	@section('title', 'Novo Usuário')
	@section('content')
			<h1>
		        Novo Usuário
		        <small>+</small>
		    </h1>
			

			<form method="POST" action="{{url('users')}}">
				@csrf			
				<div class="form-group mb-12">
				    <label for="name">Nome</label>
				    <input type="text" class="form-control" id="name" name="name" value="" placeholder="Digite o nome completo..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="cargo">Cargo/Posto/Graduação/Formação</label>
				    <input type="text" class="form-control" id="cargo" name="cargo" value="" placeholder="Digite o Cargo, Posto, Graduação ou Formação..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="email">E-mail</label>
				    <input type="email" class="form-control" id="email" name="email" value="" placeholder="Digite o E-mail..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="cpf">Cpf</label>
				    <input type="text" class="form-control" id="cpf" name="cpf" value="" placeholder="Digite o CPF..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="telefone">Celular com DDD</label>
				    <input type="text" class="form-control" id="telefone" name="telefone" value="" placeholder="Digite o Celular..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="status">Status (1 - Ativo | 0 - Inativo)</label>
				    <input type="hidden" name="status" value="1" required>
				    <input type="number" class="form-control" id="status_visible" name="status_visible" value="1" placeholder="Digite o status..." disabled="disabled" required>
				    <span class="label label-success">ATIVO</span>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="login">Login (Maior que 15 BLOQUEADO)</label>
				    <input type="hidden" name="login" value="0" required>
				    <input type="number" class="form-control" id="login_visible" name="login_visible" value="0" placeholder="Digite o login..." disabled="disabled" required>
	                    <span class="label label-success">LIBERADO</span>	                
			 	</div>
			 	

			 	<div>
			 		<hr>
			 	</div>

			 	<button type="submit" class="btn btn-primary">Cadastrar</button>
			</form>
	@endsection
@endcan