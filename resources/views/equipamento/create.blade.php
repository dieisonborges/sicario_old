@can('create_equipamento')   
	@extends('layouts.app')
	@section('title', 'Novo Usuário')
	@section('content')
			<h1>
		        Novo Equipamento
		        <small>+</small>
		    </h1>
			

			<form method="POST" action="{{url('equipamentos')}}">
				@csrf			
				<div class="form-group mb-12">
				    <label for="nome">Nome</label>
				    <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome completo..." required>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="part_number">Part Number</label>
				    <input type="text" class="form-control" id="part_number" name="part_number" value="" placeholder="Digite o PN..." >
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="serial_number">Serial Number</label>
				    <input type="text" class="form-control" id="serial_number" name="serial_number" value="" placeholder="Digite o Serial..." >
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="descricao">Descrição</label>
				    <textarea class="form-control" id="descricao" name="descricao" placeholder="Digite a Descrição.." required="required"></textarea>
			 	</div>
			 	<div class="form-group mb-12">
				    <label for="sistema">Sistema</label>
				    <input type="text" class="form-control" id="sistema" name="sistema" value="" placeholder="Digite o Sistema..." >
			 	</div>			 	

			 	<div>
			 		<hr>
			 	</div>

			 	<button type="submit" class="btn btn-primary">Cadastrar</button>
			</form>
	@endsection
@endcan