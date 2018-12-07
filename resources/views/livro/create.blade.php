@can('create_tecnico')  
	@extends('layouts.app')
	@section('title', 'Novo Ticket')
	@section('content')
			<h1>
		        <i class="fa fa-book"></i> Gerar Livro de Serviço <small>{{$setor->label}}</small>

		    </h1>
			

			<form method="POST" action="{{action('LivroController@store')}}" enctype="multipart/form-data" id="form-create">

				@csrf

				<input type="hidden" name="setor" value="{{$setor->name}}">

				<input type="hidden" name="setor_id" value="{{$setor->id}}">

				<!-- Date and time range -->
				<div class="form-group col-md-5">
					<label>Início do serviço:</label>

					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="date" class="form-control pull-right" id="inicio_data" name="inicio_data" value="{{date('Y-m-d')}}">
					
						<div class="input-group-addon">
							<i class="fa fa-clock-o"></i>
						</div>
						<input type="time" class="form-control pull-right" id="inicio_hora" name="inicio_hora" value="00:00">
					</div>
					<!-- /.input group -->
				</div>
				<!-- /.form group -->

				<!-- Date and time range -->
				<div class="form-group col-md-5">
					<label>Fim do serviço:</label>

					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="date" class="form-control pull-right" id="fim_data" name="fim_data" value="{{date('Y-m-d')}}">
					
						<div class="input-group-addon">
							<i class="fa fa-clock-o"></i>
						</div>
						<input type="time" class="form-control pull-right" id="fim_hora" name="fim_hora" value="00:00">
					</div>
					<!-- /.input group -->
				</div>
				<!-- /.form group -->				

				<div class="col-md-12">
	              <div class="form-group">
	                <label for="tecnicos">Técnicos de Serviço:</label>
	                <select name="tecnicos[]" class="form-control select2" multiple="multiple" data-placeholder="Selecione um ou mais técnicos:" style="width: 100%;">
	                	@forelse ($users as $user)
		                  <option value="{{$user->id}}">{{$user->cargo}} {{$user->name}}</option>
		                @empty
                    
                		@endforelse  
	                </select>
	              </div>
	              <!-- /.form-group -->	              
	            </div>
	            <!-- /.col -->
			 	

			 	<div class="col-md-12">
			 		
			 		<!--<button type="submit" class="btn btn-primary" onclick="document.getElementById('formSubmit').submit();">Cadastrar</button>-->
			 		
			 		<input type="submit" form="form-create" class="btn btn-primary" value="Visualizar Livro">
			 		<hr>
			 	</div>

			 	
			</form>
	@endsection
@endcan
