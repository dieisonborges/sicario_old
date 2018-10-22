@can('update_ticket')   
	@extends('layouts.app')
	@section('title', 'Editar Ticket')
	@section('content')
			<h1>
		        Editar Ticket
		        <small>{{$ticket->protocolo}}</small>
		    </h1>
			

			<form method="POST" enctype="multipart/form-data" action="{{action('TicketController@update',$id)}}">
				@csrf
				<input type="hidden" name="_method" value="PATCH">
				<div class="form-group mb-12">
				    <label for="status">Status</label>
				    <input type="text" class="form-control" id="status" name="status" value="{{$ticket->status}}" placeholder="Digite o Status..." required>
			 	</div>

			 	<div class="form-group mb-12">
				    <label for="user_id">Usuário</label>
				    <input type="text" class="form-control" id="user_id" name="user_id" value="{{$ticket->user_id}}" placeholder="Digite o usuário..." required>
			 	</div>
			 	
			 	<div class="form-group mb-12">
				    <label for="descricao">Descrição</label>
				    <textarea class="form-control" id="descricao" name="descricao" placeholder="Digite a Descrição.." required="required">{{$ticket->descricao}}</textarea>
			 	</div>

			 	<div class="form-group mb-12">
				    <label for="equipamento_id">Equipamento</label>
				    <input type="text" class="form-control" id="equipamento_id" name="equipamento_id" value="{{$ticket->equipamento_id}}" placeholder="Digite o Equipamento..." required>
			 	</div>

			 	<div class="form-group mb-12">
				    <label for="rotulo">Rótulo</label>
					
				    <label for="rotulo">Rótulo</label>				    
					<select class="form-control" name="rotulo">
						<option selected="selected" value="{{$ticket->rotulo}}">{{$ticket->rotulo}}</option>
						<option value="4">Nenhum</option>
						<option value="3">Baixo - Rotina de Manutenção</option>
						<option value="2">Médio - Intermediária (avaliar componente)</option>
						<option value="1">Alto - Urgência (reparar o mais rápido possível)</option>
						<option value="0">Crítico - Emergência (reparar imediatamente) </option>					
					</select>
			 	</div>

			 	<div class="form-group mb-12">
				    <label for="tipo">Tipo</label>				    
					<select class="form-control" name="tipo">
						<option selected="selected" value="{{$ticket->tipo}}">{{$ticket->tipo}}</option>
						<option value="0">Técnico</option>
						<option value="1">Administrativo</option>						
					</select>
			 	</div>
			 	

			 	<div>
			 		<hr>
			 	</div>

			 	<button type="submit" class="btn btn-primary">Atualizar</button>
			</form>
	@endsection
@endcan