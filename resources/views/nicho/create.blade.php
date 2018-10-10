@extends('layouts.app')
@section('title', 'Adicionar um Nicho')
@section('content')
	<h1>
        Adicionar
        <small>Novo Nicho</small>
    </h1>
		<form method="POST" action="{{url('nichos')}}">
			@csrf
			<div class="form-group mb-3">
			    <label for="titulo">Nome</label>
			    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o Nome do Nicho..." required>
		 	</div>
		 	<div class="form-group mb-3">
			    <label for="descricao">Descrição</label>
			   	<textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Digite uma breve descrição do Nicho..." required></textarea>
		 	</div>
		 	<hr>

		 	<button type="submit" class="btn btn-primary">Cadastrar Nicho</button>
		</form>
@endsection