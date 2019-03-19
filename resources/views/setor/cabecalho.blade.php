@extends('layouts.app')
@section('title', 'Editar Cabeçalho Livro')
@section('content')
		<h1>
	        Editar Cabeçalho do Livro
	        <small>{{$setor->nome}}</small>
	    </h1>
		

		<form method="POST" action="{{action('SetorController@updateCabecalho')}}">
			@csrf
			<div class="form-group mb-12">
			    <label for="name">Nome</label>
			    <span class="form-control">{{$setor->name}}</span>
		 	</div>
		 	<div class="form-group mb-12">
			    <label for="label">Rótulo</label>
			    <span class="form-control">{{$setor->label}}</span>
		 	</div>

		 	<input type="hidden" name="id" value="{{$id}}">

		 	<div class="form-group col-md-12">
			    <label for="descricao">Cabeçalho do Livro</label>				    
				<!-- /.box-header -->
	            <div class="box-body pad">
	              
	                <textarea class="textarea" placeholder="Insira o cabeçalho do livro de serviço" required="required" name="cabecalho" 
	                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$setor->cabecalho}}</textarea>
	              
	            </div>
		 	</div>


		 	<div>
		 		<hr>
		 	</div>

		 	<div class="col-md-12">
			 		
			 		<button type="submit" class="btn btn-primary" onclick="document.getElementById('formSubmit').submit();">Atualizar</button>
			 		<hr>
			 	</div>
		</form>
@endsection