 
	@extends('layouts.app') 
	@section('title', 'Novo Ticket')
	@section('content')
			<h1>
		        Novo Ticket
		        <small>+</small>
		    </h1>
			

			<form method="POST" action="{{url('clients')}}" enctype="multipart/form-data" id="form-create">
				@csrf
				

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

			 	<div class="form-group col-md-6">
				    <label for="equipamento_id">Equipamento</label>
	                <select class="form-control select2" name="equipamento_id">
	                	<option value="0">Nenhum - Nenhum equipamento.</option>
						@forelse ($equipamentos as $equipamento)
							<option value="{{$equipamento->id}}">{{$equipamento->nome}} - {{str_limit($equipamento->descricao,30)}} </option>
						@empty                    
						@endforelse 
	                </select>
			 	</div>			 	

			 	<div class="form-group col-md-12">
				    <label for="titulo">Título (Descrição Resumida)</label>
				    <input type="text" class="form-control" placeholder="Descrição resumida do problema" name="titulo" value="{{ old('titulo') }}">
			 	</div>

			 	<!--

			 	<div class="form-group col-md-12">
	                <label>Categoria</label>
	                <select name="categoria[]" class="form-control select2" multiple="multiple" data-placeholder="Selecione um ou mais categorias"
	                        style="width: 100%;">
		                  <option value="Ocorrência">Ocorrência</option>
		                  <option value="Atividade">Atividade</option>
		                  <option value="Ferramentaria">Ferramentaria</option>
		                  <option value="Canais">Canais</option>
		                  <option value="Radares">Radares</option>
		                  <option value="DBS">BDS</option>
	                </select>
	            </div>

	        	-->
	            <!-- /.form-group -->

	            <div class="form-group col-md-12">
	                <label>Setor</label>
	                <select name="setor[]" class="form-control select2" multiple="multiple" data-placeholder="Selecione um ou mais setores para atendimento"
	                        style="width: 100%;" required="required">
		                  	@forelse ($setores as $setor)
		                        <option value="{{$setor->id}}">
		                            {{$setor->name}} | {{$setor->label}}
		                        </option>
		                    @empty
	                        	<option>Nenhuma Opção</option>     
	                    	@endforelse
		                  
	                </select>
	            </div>
	            <!-- /.form-group -->

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
