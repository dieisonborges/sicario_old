@extends('layouts.app')
@section('title', 'Editar Permission (Regra)')
@section('content')
		<h1>
	        Editar Usuário
	        <small>{{$permission->nome}}</small>
	    </h1>
		

		<form method="POST" enctype="multipart/form-data" action="{{action('PermissionController@update',$id)}}">
			@csrf
			<input type="hidden" name="_method" value="PATCH">
			<div class="form-group mb-12">
			    <label for="name">Nome</label>
			    <input type="text" class="form-control" id="name" name="name" value="{{$permission->name}}" placeholder="Digite o Nome..." required>
		 	</div>
		 	<div class="form-group mb-12">
			    <label for="label">Rótulo</label>
			    <input type="text" class="form-control" id="label" name="label" value="{{$permission->label}}" placeholder="Digite o Rótulo..." required>
		 	</div>

		 	<div>
		 		<hr>
		 	</div>

		 	<button type="submit" class="btn btn-primary">Atualizar</button>
		</form>
@endsection