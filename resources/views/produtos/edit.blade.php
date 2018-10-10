@extends('layouts.app')
@section('title', 'Adicionar um Produto - '.$produto->titulo)
@section('content')
		<h1>
	        Editar Produto 
	        <small>{{$produto->titulo}}</small>
	    </h1>
		@if($message = Session::get('success'))
			<div class="alert alert-success">
				{{$message}}
			</div>
		@endif

		@if(count($errors)>0)
			<div class="alert alert-danger">
				<ul>
					@foreach($errors->all() as $error)
					<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<form method="POST" enctype="multipart/form-data" action="{{action('ProdutosController@update',$id)}}">
			@csrf
			<input type="hidden" name="_method" value="PATCH">
			<div class="form-group mb-12">
			    <label for="sku">SKU</label>
			    <input type="text" class="form-control" id="sku" name="sku" value="{{$produto->sku}}" placeholder="Digite o Código do Produto..." required>
		 	</div>
		 	<div class="form-group mb-12">
			    <label for="titulo">Título</label>
			    <input type="text" class="form-control" id="titulo" name="titulo" value="{{$produto->titulo}}" placeholder="Digite o Nome do Produto..." required>
		 	</div>
		 	<div class="form-group mb-12">
			    <label for="nicho">Segmento Principal (Nicho)</label>
			    <select class="form-control" id="nicho" name="nicho" required="">
			    	<option selected="selected" value="{{$produto->nicho}}">{{$produto->nicho}}</option>
					<option value="Petshop">Petshop</option>
					<option value="Caixas de Som">Caixas de Som</option>
					<option value="Fones de Ouvido">Fones de Ouvido</option>
					<option value="Pesca e Camping">Pesca e Camping</option>
					<option value="Celular">Celular</option>
					<option value="Acessórios para Celular">Acessórios para Celular</option>
					<option value="Cabos">Cabos</option>
					<option value="Musicais">Musicais</option>
					<option value="Moda Feminina">Moda Feminina</option>
					<option value="Roupas">Roupas</option>
					<option value="Perfume">Perfume</option>
					<option value="Automotivo">Automotivo</option>
					<option value="Material de Escritório">Material de Escritório</option>
					<option value="Artesanato">Artesanato</option>
			    </select>
		 	</div>
		 	<div class="form-group mb-12">
			    <label for="descricao">Descrição</label>
			   	<textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Digite uma breve descrição do Produto..." required>{{$produto->descricao}}</textarea>
		 	</div>
		 	<label for="preco">Preço Mínimo (Revenda) R$: </label>
		 	<div class="input-group mb-12">
			    
			    <input type="number" step=".01" class="form-control" id="preco" name="preco" value="{{$produto->preco}}" placeholder="0,00" required>
		 	</div>
		 	<br>
		 	<div class="form-group mb-12">		 		
		 		@if(file_exists("./img/produtos/".$produto->imagem))
		 		<label>Imagem Atual</label>
				<div class="col-md-12" style="margin-bottom: 20px;">
					<img src="{{url('img/produtos/'.$produto->imagem)}}" width="30%" alt="Imagem Produto" class="img-fluid img-thumbnail">
				</div>
				@endif
		 	</div>
		 	<br>
		 	<div class="form-group mb-12">
		 		<label for="imgproduto">Nova Imagem</label>
		 		<input type="file" class="btn form-control-file" id="imgproduto" name="imgproduto">
		 	</div>

		 	<div>
		 		<hr>
		 	</div>

		 	<button type="submit" class="btn btn-primary">Atualizar Produto</button>
		</form>
@endsection