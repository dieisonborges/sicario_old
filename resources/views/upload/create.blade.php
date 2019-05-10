@extends('layouts.app')
@section('title', 'Nova Upload')
@section('content')
		<h1>
	        Upload de Arquivos
	        <small>+</small>
	    </h1>
		

		<form action="{{url('uploads')}}" method="POST" enctype="multipart/form-data">
			@csrf	

			<input type="hidden" name="id" value="{{$id}}">	

			<input type="hidden" name="area" value="{{$area}}">	

			<div class="form-group mb-12">
			    <label for="titulo">Título: </label>
			    <input type="text" class="form-control" id="titulo" name="titulo" value="" placeholder="Digite o Título do Arquivo..." required>
		 	</div>

		 	<div class="form-group mb-12">
			    <label for="file" >Arquivo: </label>
			    <input type="file" name="file" required="required" accept="image/*|application/pdf">
			    <span style="font-size: 15px; color: red;">Arquivos suportados: <b>jpeg,png,jpg,pdf</b></span>
		 	</div>
		 	
    		<button type="submit" class="btn btn-success"><i class="fa fa-paper-plane"></i> Enviar</button>
		 	

		 	<div>
		 		<hr class="hr col-md-12">
		 	</div>

		 	
		</form>

		<a class="btn btn-primary" href="javascript:history.go(-1)"><i class="fa fa-arrow-left"></i> Voltar</a>
@endsection