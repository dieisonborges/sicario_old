@extends('layouts.app')
@section('title', $produto->titulo)
@section('content')
	<h1>
        Produto
        <small>{{$produto->titulo}}</small>
    </h1>
	<div class="row">
		@if(file_exists("./img/produtos/".$produto->imagem))
		<div class="col-md-6">
			<img src="{{URL::to('storage/'.$produto->imagem)}}" alt="Imagem Produto" class="img-fluid img-thumbnail">
		</div>
		@endif
		<div class="col-md-6">
			<ul>
				<li><strong>SKU: </strong> {{$produto->sku}}</li>
				<li><strong>Preço Mínimo (Revenda) R$: </strong> R$ {{number_format($produto->preco,2,',','.')}}</li>
				<li><strong>Adicionado em: </strong>{{date("d/m/Y H:i", strtotime($produto->created_at))}}</li>	
				<li><span class="btn btn-primary">{{$produto->nicho}}</span></li>	
			</ul>	
			<p>{{$produto->descricao}}</p>
			<img class="" src="{{URL::to('storage/'.$produto->imagem)}}" alt="">
		</div>
	</div>
	<a href="javascript:history.go(-1)">Voltar</a>
@endsection