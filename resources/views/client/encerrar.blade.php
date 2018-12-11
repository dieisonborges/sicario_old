 
	@extends('layouts.app')
	@section('title', 'Adicionar Ação ao Ticket')
	@section('content')
			<h1>
		        Encerrar Ticket
		        <small>{{$ticket->protocolo}}</small>
		    </h1>

		    <div class="box-body">              
              <div class="callout callout-danger">
                <h5>Usuário: <b>{{$ticket->users->name}}</b></h5>
                <h5>Número de Protocolo: <b>{{$ticket->protocolo}}</b></h5>
                <h5>Aberto em: <b>{{date('d/m/Y H:i:s', strtotime($ticket->created_at))}}</b></h5>
              </div>              
              
            </div>

			<form method="POST" enctype="multipart/form-data" action="{{action('ClientController@storeEncerrar')}}" id="form-edit">
				@csrf

				<input type="hidden" name="ticket_id" value="{{$ticket->id}}">				
			 	
			 	<div class="form-group col-md-12">
				    <label for="descricao">Deixe uma mensagem de encerramento</label>				    
					<!-- /.box-header -->
		            <div class="box-body pad">
		              <form>
		                <textarea class="textarea" placeholder="Detalhe seu o problema ou solicitação" required="required" name="descricao" 
		                          style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
		              </form>
		            </div>
			 	</div> 	


			 	<div>
			 		<hr>
			 	</div>

			 	<input type="submit" form="form-edit" class="btn btn-danger" value="Encerrar">

			</form>

			
	@endsection
