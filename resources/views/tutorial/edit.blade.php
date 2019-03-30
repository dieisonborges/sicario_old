@extends('layouts.app')
@section('title', 'Editar Tutorial (Regra)')
@section('content')
		<h1>
	        Editar Tutorial (Grupo)
	        <small>{{$tutorial->nome}}</small>
	    </h1>
		

		<form method="POST" enctype="multipart/form-data" action="{{action('TutorialController@update',$id)}}">
			@csrf			
			<input type="hidden" name="_method" value="PATCH">
			<div class="form-group col-lg-12">
			    <label for="titulo">Título</label>
			    <input type="text" class="form-control" id="titulo" name="titulo" value="{{$tutorial->titulo}}" placeholder="Digite o título do seu tutorial..." required>
		 	</div>

		 	<div class="form-group col-lg-12">
			    <label for="palavras_chave">Palavras Chave (Separe por vírgula)</label>
			    <input type="text" class="form-control" id="palavras_chave" name="palavras_chave" value="{{$tutorial->palavras_chave}}" placeholder="Digite as palavras chave que serão usadas para buscar..." required>
		 	</div>
		 	<br>
		 	<hr class="hr">
		 	<br>
		 	<div class="form-group col-lg-12">
	            <div class="box-header">
	              <h3 class="box-title">Tutorial
	                <small>Conteúdo:</small>
	              </h3>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body pad">	              
	                <textarea id="editorLoad1" name="conteudo" rows="100" cols="80">{{$tutorial->conteudo}}</textarea>
	            </div>
          </div>
          <!-- /.box -->	 	

		 	<div>
		 		<hr>
		 	</div>

		 	<button type="submit" class="btn btn-primary">Salvar</button>
		</form>
@endsection