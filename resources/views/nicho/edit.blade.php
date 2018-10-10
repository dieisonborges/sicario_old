@extends('layouts.app')
@section('title', 'Editar Nicho')
@section('content')
		<h1>
	        Editar Nicho
	        <small>{{$nicho->nome}}</small>
	    </h1>
		
		
		<form method="POST" enctype="multipart/form-data" action="{{action('NichoController@update',$id)}}">
			@csrf
			<input type="hidden" name="_method" value="PATCH">
			<div class="form-group mb-3">
			    <label for="titulo">Nome</label>
			    <input type="text" class="form-control" id="nome" name="nome" value="{{$nicho->nome}}" required>
		 	</div>
		 	<div class="form-group mb-3">
			    <label for="descricao">Descrição</label>
			   	<textarea class="form-control" id="descricao" name="descricao" rows="3"  required>{{$nicho->descricao}}</textarea>
		 	</div>
		 	<div>

		 		<hr>

		 	</div>
		 	<button type="submit" class="btn btn-primary">Atualizar Nicho</button>
		</form>
@endsection
