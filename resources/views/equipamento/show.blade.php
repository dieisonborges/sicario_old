@can('read_equipamento')   
	@extends('layouts.app')
	@section('title', 'Equipamento')
	@section('content')
				

		<h1>
		        Equipamento 
		        <small>{{$equipamento->nome}}</small>
		    </h1>

		    <div class="form-group col-md-12">
				    <label for="status">Status</label>
				    <!--
                    0  => "Com Inoperância(s)",
                    1  => "Operacional",  
                    -->
                    
                    @switch($equipamento->status)
                        @case(1)
                            <a href="{{URL::to('equipamentos/dashboard')}}" class="btn btn-flat btn-success btn-md col-md-12">Operacional</a>
                            @break                                                               
                        @default
                            <a href="{{URL::to('equipamentos/dashboard')}}" class="btn btn-flat btn-danger btn-md col-md-12">Com Inoperância(s)</a>
                    @endswitch
                	
				    
			</div>

		    <div class="box-body col-md-4">              
              <div class="callout callout-info">
                <h5>ID: <b>{{$equipamento->id}}</b></h5>
                <h5>Nome: <b>{{$equipamento->nome}}</b></h5>
                <h5>PN: <b>{{$equipamento->part_number}}</b></h5>
                <h5>SN: <b>{{$equipamento->serial_number}}</b></h5>
                <h5>Sistema: <b>{{$equipamento->sistema_id}}</b></h5>
                <h5>Criado em:  <b>{{$equipamento->created_at}}</b></h5>
                <h5>Modificado em: <b>{{$equipamento->updated_at}}</b></h5>

                <br>

                <h5>Sistema: <b>{{$equipamento->sistema_id}}</b></h5>
              </div>
        	</div>

        	<div class="box-body col-md-8">              
              <div class="form-group col-md-12">
				    <label for="descricao">Descrição</label>				    
					<!-- /.box-header -->
		            
		              
		                <span class="form-control" placeholder="Detalhe seu o problema ou solicitação" required="required" name="descricao" 
		                          style="width: 100%; min-height: 230px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$equipamento->descricao}}
		              </span>
		            
			 	</div>	
        	</div>

        	<div class="box-body col-md-12">

        		<a href="javascript:history.go(-1)" class="btn btn-info">Voltar</a>

        		<a class="btn btn-warning" href="{{URL::to('equipamentos/'.$equipamento->id.'/edit')}}"><i class="fa fa-edit"></i> Editar</a>

        	</div>

			 	
			 	
		
		
	@endsection
@endcan 