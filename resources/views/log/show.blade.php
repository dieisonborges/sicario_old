@can('read_log')  
	@extends('layouts.app')
	@section('title', 'Log')
	@section('content')
		<h1>
	        Logs (Registro)
	        <small> nº {{$log->id}}</small>
	    </h1>
		<div class="row">
			<div class="col-md-6">	
				<div class="box box-warning">
					<h3>Registro</h3>
					<label><strong>ID: </strong></label>
					<span class="form-control"> {{$log->id}}</span>

					<label><strong>Created At: </strong> </label>
					<span class="form-control"> {{date('d/m/Y H:i:s', strtotime($log->created_at))}}</span>

					<label><strong>Updated At: </strong></label>				
					<span class="form-control"> {{date('d/m/Y H:i:s', strtotime($log->updated_at))}}</span>

					<label><strong>IP: </strong></label>
					<span class="form-control">{{$log->ip}}</span>

					<label><strong>Mac: </strong></label>
					<span class="form-control">{{$log->mac}}</span>

					<label><strong>Host: </strong></label>
					<span class="form-control">{{$log->host}}</span>

					<label><strong>Filename: </strong></label>
					<span class="form-control">{{$log->filename}}</span>
					
				</div>
			</div>

			@if(isset($user))

			<div class="col-md-6">
				<div class="box box-danger">
					<h3>Usuário</h3>
					<label><strong>Cargo: </strong></label>
					<span class="form-control"> {{$user->cargo}}</span>

					<label><strong>Nome: </strong> </label>
					<span class="form-control">{{$user->name}}</span>

					<label><strong>CPF: </strong></label>				
					<span class="form-control"> {{$user->cpf}}</span>

				</div>
			</div>
			@else

			<div class="col-md-6">
				<div class="box box-danger">
					<h3>Operação não necessita LOGIN</h3>

				</div>
			</div>


			@endif

			<div class="col-md-12">
				<div class="box box-success">
					<label><strong>Info: </strong></label>
					<textarea class="form-control" style="min-height: 200px;" >{{$log->info}}</textarea>					
				</div>
				
			</div>

		</div>
		
		
		<a href="javascript:history.go(-1)">Voltar</a>
	@endsection
@endcan