@extends('layouts.app')
@section('title', 'Nova Upload')
@section('content')
		<h1>
	        Imagem de Perfil
	        <small>Alterar</small>
	    </h1>
		

		<form action="{{url('clients')}}/imagemUpdate" method="POST" enctype="multipart/form-data">
			@csrf	

		 	<div class="form-group mb-12">
			    <label for="file" >Nova Imagem: </label>
			    <input type="file" name="file" required="required" accept="image/*|application/pdf">
			    <span style="font-size: 15px; color: red;">Arquivos suportados: <b>jpeg, png, jpg</b></span>
		 	</div>
		 	
    		<button type="submit" class="btn btn-success">Enviar</button>
		 	

		 	<div>
		 		<hr class="hr col-md-12">
		 	</div>

		 	
		</form>

		<a class="btn btn-primary" href="javascript:history.go(-1)"><i class="fa fa-arrow-left"></i> Voltar</a>
@endsection