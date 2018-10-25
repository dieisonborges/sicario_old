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

			 	<div class="box">
		            <div class="box-header">
		              <h3 class="box-title">Descrição 
		                <small>Detalhada</small>
		              </h3>
		              
		              <!-- /. tools -->
		            </div>
		            <!-- /.box-header -->
		            <div class="box-body pad">
		              <form>
		                <textarea class="textarea" placeholder="Detalhe o problema ou serviço."
		                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" id="descricao" name="descricao"  required="required">{{$ticket->descricao}}</textarea>
		              </form>
		            </div>
		        </div>

			 	<div class="form-group mb-12">
				    <label for="equipamento_id">Equipamento</label>
				    <input type="text" class="form-control" id="equipamento_id" name="equipamento_id" value="{{$equipamento->nome}}" placeholder="Digite o Equipamento..." required>
			 	</div>

			 	<div class="form-group mb-12">
				    <label for="rotulo">Rótulo</label>
					
				    <label for="rotulo">Rótulo</label>				    
					<select class="form-control" name="rotulo">

						<option selected="selected" value="{{$ticket->rotulo}}">{{$rotulos[$ticket->rotulo]}}</option>
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
						<option selected="selected" value="{{$ticket->tipo}}">{{$tipos[$ticket->tipo]}}</option>
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