@extends('layouts.app')
@section('title', 'Lista de Produtos')
@section('content')
	<h1>Produtos</h1>
	@if($message = Session::get('success'))
		<div class="alert alert-success">
			{{$message}}
		</div>
	@endif

	<div class="row">

		<div class="col-md-12">	
			<form method="POST" enctype="multipart/form-data" action="{{url('produtos/busca')}}">
				@csrf
				<div class="input-group input-group-lg">			
			        <input type="text" class="form-control" id="busca" name="busca" placeholder="Procurar produto..." value="{{$buscar}}">
			            <span class="input-group-btn">
			              <button type="submit" class="btn btn-info btn-flat">Buscar</button>
			            </span>
			    </div>
			</form>
		</div>

		<br><br><br>

		@foreach ($produtos as $produto)
		<div class="col-md-3">
			<div class="col-md-12" style="margin-bottom: 20px; height: 300px;">			
					<a href="{{URL::to('produtos')}}/{{$produto->id}}">
						<img src="{{ URL::to('storage/'.$produto->imagem)}}" alt="Imagem Produto"  width="200" height="200"   class="img-fluid img-thumbnail">
					</a>
			    <h4><a href="{{URL::to('produtos')}}/{{$produto->id}}">{{$produto->titulo}}</a></h4>
				<div class="mb-3">

					<a href="{{URL::to('produtos')}}/{{$produto->id}}" class="btn btn-primary" style="margin-top: 10px; margin-bottom: 10px;">{{$produto->nicho}} </a>	
				</div>
				
			</div>
			<div class="col-md-12">
				<!-- Excluir -->
					<form method="POST" enctype="multipart/form-data" action="{{action('ProdutosController@destroy',$produto->id)}}">
						@csrf
						<input type="hidden" name="_method" value="DELETE">
						<button class="btn btn-danger" style="margin-top: 10px; margin-bottom: 10px;">Excluir</button>

						<!-- Editar -->
						<a href="{{URL::to('produtos/'.$produto->id.'/edit')}}" class="btn btn-warning">Editar</a>

					</form>				
			</div>
			<hr class="col-md-10">
		</div>
		@endforeach	

	</div>
	{{$produtos->links()}}
@endsection