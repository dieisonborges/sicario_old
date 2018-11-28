@can('create_tecnico')  
	@extends('layouts.app')
	@section('title', 'Novo Ticket')
	@section('content')
			<h1>
		        Gerar Livro de Serviço
		        <small>+</small>
		    </h1>
			

			<form method="POST" action="{{url('livros')}}" enctype="multipart/form-data" id="form-create">
				@csrf

				<!-- Date and time range -->
				<div class="form-group col-md-4">
					<label>Início do serviço:</label>

					<div class="input-group col-md-5">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="date" class="form-control pull-right" id="inicio_data" name="inicio_data" value="{{date('Y-m-d',strtotime('-1 day', strtotime(date('Y-m-d'))))}}">
					
						<div class="input-group-addon">
							<i class="fa fa-clock-o"></i>
						</div>
						<input type="time" class="form-control pull-right" id="inicio_hora" name="inicio_hora" value="{{date('h:i')}}">
					</div>
					<!-- /.input group -->
				</div>
				<!-- /.form group -->

				<!-- Date and time range -->
				<div class="form-group col-md-4">
					<label>Fim do serviço:</label>

					<div class="input-group col-md-5">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="date" class="form-control pull-right" id="fim_data" name="fim_data" value="{{date('Y-m-d')}}">
					
						<div class="input-group-addon">
							<i class="fa fa-clock-o"></i>
						</div>
						<input type="time" class="form-control pull-right" id="fim_hora" name="fim_hora" value="{{date('h:i')}}">
					</div>
					<!-- /.input group -->
				</div>
				<!-- /.form group -->

			 	

			 	<div class="form-group col-md-12">
				    <label for="tecnicos">Técnicos de Serviço:</label>				    
					<!-- /.box-header -->
		            <div class="box-body pad">
		              <form>
		                <textarea class="textarea" placeholder="Nomes dos técnicos separados por vírgula." required="required" name="tecnicos" 
		                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{ old('tecnicos') }}</textarea>
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
