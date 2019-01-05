@can('update_equipamento')   
	@extends('layouts.app')
	@section('title', 'Editar Equipamento')
	@section('content')
			<h1>
		        Editar Equipamento
		        <small>{{$equipamento->nome}}</small>
		    </h1>
			

			<form method="POST" enctype="multipart/form-data" action="{{action('EquipamentoController@update',$id)}}">
				@csrf
				<input type="hidden" name="_method" value="PATCH">
				<div class="form-group mb-12">
				    <label for="nome">Nome</label>
				    <input type="text" class="form-control" id="nome" name="nome" value="{{$equipamento->nome}}" placeholder="Digite o Nome..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="part_number">Part Number</label>
				    <input type="text" class="form-control" id="part_number" name="part_number" value="{{$equipamento->part_number}}" placeholder="Digite o PN...">
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="serial_number">Serial Number</label>
				    <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{$equipamento->serial_number}}" placeholder="Digite o SN...">
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="descricao">Descrição</label>
				    <textarea class="form-control" id="descricao" name="descricao" placeholder="Digite a Descrição.." required="required">{{$equipamento->descricao}}</textarea>
			 	</div>			 	

			 	<div class="form-group mb-12">
				    <label for="sistema_id">Sistema</label>
	                <select class="form-control select2" name="sistema_id">
	                	<option value="{{$equipamento->sistema_id}}">{{$equipamento->sistema_id}}</option>
						@forelse ($sistemas as $sistema)
							<option value="{{$sistema->id}}">{{$sistema->nome}} - {{str_limit($sistema->descricao,60)}} </option>
						@empty                    
						@endforelse 
	                </select>
			 	</div>
			 	

			 	<div>
			 		<hr>
			 	</div>

			 	<button type="submit" class="btn btn-primary">Atualizar</button>
			</form>
	@endsection
@endcan