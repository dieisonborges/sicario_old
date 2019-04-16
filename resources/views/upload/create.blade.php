@extends('layouts.app')
@section('title', 'Nova Upload')
@section('content')
		<h1>
	        Upload de Arquivos
	        <small>+</small>
	    </h1>
		

		<form method="POST" action="{{url('uploads')}}">
			@csrf			
			<div class="form-group mb-12">
			    <label for="name">Nome</label>
			    <input type="text" class="form-control" id="name" name="name" value="" placeholder="Digite o Nome..." required>
		 	</div>
		 	<div class="form-group mb-12">
			    <label for="label">Rótulo</label>
			    <input type="text" class="form-control" id="label" name="label" value="" placeholder="Digite o Rótulo..." required>
		 	</div>
		 	

		 	<div>
		 		<hr>
		 	</div>

		 	<button type="submit" class="btn btn-primary">cadastrar</button>
		</form>
@endsection