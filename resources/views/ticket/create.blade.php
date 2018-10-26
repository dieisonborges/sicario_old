@can('create_ticket')   
	@extends('layouts.app')
	@section('title', 'Novo Ticket')
	@section('content')
			<h1>
		        Novo Ticket
		        <small>+</small>
		    </h1>
			

			<form method="POST" action="{{url('tickets')}}" enctype="multipart/form-data" id="formSubmit">
				@csrf
				<div class="form-group col-md-2">
				    <label for="status">Status</label>
				    <select class="form-control" name="status">
						<option value="0">Fechado</option>
						<option value="1" selected="selected">Aberto</option>				
					</select>
			 	</div> 				 	

			 	<div class="form-group col-md-4">					
				    <label for="rotulo">Rótulo (Criticidade)</label>				    
					<select class="form-control" name="rotulo">
						<option value="4">Nenhum</option>
						<option value="3">Baixo - Rotina de Manutenção</option>
						<option value="2">Médio - Intermediária (avaliar componente)</option>
						<option value="1">Alto - Urgência (reparar o mais rápido possível)</option>
						<option value="0">Crítico - Emergência (reparar imediatamente) </option>					
					</select>
			 	</div>

			 	<div class="form-group  col-md-2">
				    <label for="tipo">Tipo</label>				    
					<select class="form-control" name="tipo">
						<option value="0">Técnico</option>
						<option value="1">Administrativo</option>						
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
			 		
			 		<button type="submit" class="btn btn-primary" onclick="document.getElementById('formSubmit').submit();">Cadastrar</button>
			 		<hr>
			 	</div>

			 	
			</form>
	@endsection
@endcan