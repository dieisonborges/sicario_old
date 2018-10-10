@extends('layouts.app')
@section('title', 'Adicionar um Produtos')
@section('content')
	<h1>
        Adicionar
        <small>Novo Produto</small>
    </h1>
		
		
		<form method="POST" action="{{url('produtos')}}">
			@csrf
			<div class="form-group mb-3">
			    <label for="sku">SKU</label>
			    <input type="text" class="form-control" id="sku" name="sku" placeholder="Digite o Código do Produto..." required>
		 	</div>
		 	<div class="form-group mb-3">
			    <label for="titulo">Título</label>
			    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Digite o Nome do Produto..." required>
		 	</div>
		 	<div class="form-group mb-12">
			    <label for="nicho">Segmento Principal (Nicho)</label>
			    <select class="form-control" id="nicho" name="nicho" required="">
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
		 	<div class="form-group mb-3">
			    <label for="descricao">Descrição</label>
			   	<textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Digite uma breve descrição do Produto..." required></textarea>
		 	</div>
		 	<label for="preco">Preço</label>
		 	<div class="input-group mb-3">
			    <div class="input-group-prepend">
			    	<span class="input-group-text" id="basic-addon1">R$</span>
				</div>
			    <input type="number" step=".01" class="form-control" id="preco" name="preco" placeholder="0,00" required>
		 	</div>

		 	<hr>

		 	<button type="submit" class="btn btn-primary">Cadastrar Produto</button>
		</form>
@endsection