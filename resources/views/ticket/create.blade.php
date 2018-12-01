@can('create_ticket')   
	@extends('layouts.app')
	@section('title', 'Novo Ticket')
	@section('content')
			<h1>
		        Novo Ticket
		        <small>+</small>
		    </h1>
			

			<form method="POST" action="{{url('tickets')}}" enctype="multipart/form-data" id="form-create">
				@csrf
				<div class="form-group col-md-2">
				    <label for="status">Status</label>
				    <select class="form-control" name="status">
						   <option value=""> Aberto</option>
					</select>
			 	</div>

			 	<div class="form-group col-md-4">					
				    <label for="rotulo">Rótulo (Criticidade)</label>				    
					<select class="form-control" name="rotulo">						

	                	@foreach ($rotulos as $Key => $rotulo)
						   <option value="{{$Key}}"> {{$rotulo}}</option>
						@endforeach 
											
					</select>
			 	</div>			 	

			 	<div class="form-group col-md-2">
				    <label for="tipo">Tipo</label>				    
					<select class="form-control" name="tipo">
						@foreach ($tipos as $Key => $tipo)
						   <option value="{{$Key}}"> {{$tipo}}</option>
						@endforeach 				
					</select>
			 	</div>

			 	<div class="form-group col-md-4">
				    <label for="equipamento_id">Equipamento</label>
				    <select class="form-control" name="equipamento_id">
				    	<option selected="selected" value="">Nenhum</option>
				    	@forelse ($equipamentos as $equipamento)
				    		<option value="{{$equipamento->id}}">{{$equipamento->nome}} - {{$equipamento->descricao}} </option>
					    @empty                    
	                	@endforelse 			
					</select>
			 	</div>

			 	<div class="form-group col-md-12">
				    <label for="titulo">Título (Descrição Resumida)</label>
				    <input type="text" class="form-control" placeholder="Descrição resumida do problema" name="titulo" value="{{ old('titulo') }}">
			 	</div>

			 	<div class="form-group col-md-12">
				    <label for="descricao">Descrição</label>				    
					<!-- /.box-header -->
		            <div class="box-body pad">
		              <form>
		                <textarea class="textarea" placeholder="Detalhe seu o problema ou solicitação" required="required" name="descricao" 
		                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('descricao') }}</textarea>
		              </form>
		            </div>
			 	</div>		 	

			 	<div class="col-md-12">
			 		
			 		<!--<button type="submit" class="btn btn-primary" onclick="document.getElementById('formSubmit').submit();">Cadastrar</button>-->
			 		
			 		<input type="submit" form="form-create" class="btn btn-primary" value="Cadastrar">
			 		<hr>
			 	</div>

			 	
			</form>
	@endsection
@endcan