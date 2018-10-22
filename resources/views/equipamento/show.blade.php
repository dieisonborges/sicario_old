@can('read_equipamento')   
	@extends('layouts.app')
	@section('title', 'Equipamento')
	@section('content')
		<h1>
	        Equipamento
	        <small>{{$equipamento->name}}</small>
	    </h1>
		<div class="row">		
			<div class="col-md-6">
				<ul>
					<li><strong>ID: </strong> {{$equipamento->id}}</li>
					<li><strong>Nome: </strong> {{$equipamento->nome}}</li>
					<li><strong>PN: </strong> {{$equipamento->part_number}}</li>
					<li><strong>SN: </strong> {{$equipamento->serial_number}}</li>
					<li><strong>Sistema: </strong> {{$equipamento->sistema_id}}</li>
					<li><strong>Criado em: </strong> {{$equipamento->created_at}}</li>
					<li><strong>Editado em: </strong> {{$equipamento->updated_at}}</li>
					
					<p>{{$equipamento->descricao}}</p>
				</ul>	
			</div>

		</div>
		
		
		<a href="javascript:history.go(-1)">Voltar</a>
	@endsection
@endcan