@can('read_tecnico')      
	@extends('layouts.app')
	@section('title', 'Visualizar Ticket')
	@section('content')

        <a href="#footer" class="btn btn-primary" style="float: right;"><span class="fa fa-arrow-down"></span></a>

			  <h1>
		        Ticket 
		        <small>{{$ticket->protocolo}}</small>
		    </h1>



		    <div class="box-body col-md-4">              
              <div class="callout callout-info">
                <h5>Usuário: <b>{{$ticket->users->name}}</b></h5>
                <h5>Número de Protocolo: <b>{{$ticket->protocolo}}</b></h5>
                <h5>Aberto em: <b>{{date('d/m/Y H:i:s', strtotime($ticket->created_at))}}</b></h5>
                <h5>Dias abertos: <b>{{ number_format($data_aberto, 0) }}</b></h5>
              </div>
        </div>	

			 	<div class="form-group col-md-4">
				    <label for="status">Status</label>
				    <!--
                    0  => "Fechado",
                    1  => "Aberto",  
                    -->
                    
                    @switch($ticket->status)
                        @case(0)
                            <span class="btn btn-flat btn-success btn-md col-md-12">Fechado</span>
                            @break                                                               
                        @default
                            <span class="btn btn-flat btn-warning btn-md col-md-12">Aberto</span>
                    @endswitch
                	
				    
			 	</div>

			 	<div class="form-group col-md-4">					
				    <label for="rotulo">Rótulo (Criticidade)</label>
							<!--
                            0   =>  "Crítico - Emergência (resolver imediatamente)",
                            1   =>  "Alto - Urgência (resolver o mais rápido possível)",
                            2   =>  "Médio - Intermediária (avaliar situação)",
                            3   =>  "Baixo - Rotineiro ou Planejado",
                            -->
                            @switch($ticket->rotulo)
                                @case(0)
                                    <span class="btn btn-flat btn-danger btn-md col-md-12">Crítico - Emergência (resolver imediatamente)</span>
                                    @break
                                @case(1)
                                    <span class="btn btn-flat btn-warning btn-md col-md-12">Alto - Urgência (resolver o mais rápido possível)</span>
                                    @break
                                @case(2)
                                    <span class="btn btn-flat bg-purple btn-md col-md-12">Médio - Intermediária (avaliar situação)</span>
                                    @break
                                @case(3)
                                    <span class="btn btn-flat bg-navy btn-md col-md-12">Baixo - Rotineiro ou Planejado</span>
                                    @break
                                @case(4)
                                    <span class="btn btn-flat btn-info btn-md col-md-12">Nenhum</span>
                                    @break
                                @break                           

                            @endswitch
			 	</div>			 	

			 	<div class="form-group col-md-4">
				    <label for="tipo">Tipo</label>	
				    <span class="ol-md-12 form-control">{{$tipos[$ticket->tipo]}}</span>
			 	</div>

			 	<div class="form-group col-md-4">
				    <label for="equipamento_id">Equipamento</label>
            @if($ticket->equipamento_id)
				    <span class="col-md-12 form-control">{{$ticket->equipamentos->nome}}</span>
            @else
            <span class="col-md-12 form-control">Nenhum</span>
            @endif
				    
			 	</div>
		 	

			 	<!--<a href="javascript:history.go(-1)">Voltar</a>-->


				<div class="col-md-12">
					<div class="box box-default">
					<div class="box-header with-border">
						<i class="fa fa-warning"></i>
						<h3 class="box-title">Ações</h3>

					</div>
					<!-- /.box-header -->

					</div>
					<!-- /.box -->
				</div>
				<!-- /.col -->




			
    <!-- Main content -->
    <section class="content">

      <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
                    {{date('d M. Y', strtotime($ticket->created_at))}}
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-ticket bg-blue"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> {{date('H:i:s', strtotime($ticket->created_at))}}</span>

                <h3 class="timeline-header"><a href="#">{{$ticket->users->name}}</a> {{$ticket->titulo}}</h3>

                <div class="timeline-body">
                 {!!html_entity_decode($ticket->descricao)!!}
                </div>
                <div class="timeline-footer">
                  <span class="btn btn-warning btn-xs">Abertura</span>
                </div>
              </div>
            </li>
            <!-- END timeline item -->

            @foreach ($prontuarios as $prontuario)
                <!-- timeline time label -->
                <li class="time-label">
                      <span class="bg-red">
                        {{date('d M. Y', strtotime($prontuario->created_at))}}
                      </span>
                </li>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <li>
                  <i class="fa fa-comments  bg-gray"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i> {{date('H:i:s', strtotime($prontuario->created_at))}}</span>

                    <h3 class="timeline-header"><a href="#">{{$prontuario->users->name}}</a></h3>

                    <div class="timeline-body">
                     {!!html_entity_decode($prontuario->descricao)!!}
                                      
                  </div>
                </li>
                <!-- END timeline item -->
            @endforeach 
            
            
            <!-- timeline item -->
            
            

            @if (($ticket->status)==1)

            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>

            

            @else

            <!-- -------------- ENCERRAMENTO ------------- -->

            

            <!-- timeline time label -->
            
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-close bg-gray"></i>
              <div class="timeline-item">
                <h3 class="timeline-header"><a href="#">Encerrado</a></h3>
              </div>
            </li>
            <!-- END timeline item -->

            <li>
              <i class="fa fa-flag-checkered bg-green"></i>
            </li>

            <!-- -------------- FIM ENCERRAMENTO ------------- -->
    
            @endif  

          </ul>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->
    <section class="content">

    @if (($ticket->status)==1)

      <a  class="btn btn-warning btn-md" href="{{URL::to('tecnicos/'.$setor->name.'/'.$ticket->id.'/edit')}}"><i class="fa fa-edit"></i> Editar Ticket</a>
    
      <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/acao"  class="btn btn-info btn-md"><i class="fa fa-plus-circle"></i> Nova Ação</a>

      <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/encerrar" class="btn btn-danger btn-md"><i class="fa fa-times-circle"></i> Encerrar Ticket</a>

    @else

    <a href="{{URL::to('tecnicos')}}/{{$setor->name}}/{{$ticket->id}}/reabrir" class="btn btn-success btn-md"><i class="fa fa-arrow-up"></i> Reabrir Ticket</a>
        
    @endif    

    <a  class="btn btn-info btn-md" style="float: right;" href="{{URL::to('tecnicos/'.$setor->name.'/'.$ticket->id.'/setors')}}"><i class="fa fa-group"></i> Setores Vinculados Ao Ticket</a>
    
    </section>

    <section class="content">

        <div class="form-group col-md-12">
            <div class="box-header">
            <h3 class="box-title">Arquivos: </h3>

            <a href="{{URL::to('uploads')}}/{{$ticket->id}}/create/ticket"  class="btn btn-info btn-md" style="float: right;"><i class="fa fa-plus-circle"></i> Novo Arquivo</a>
            
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Titulo</th>
                        <th>Ver</th>
                    </tr>
                    @forelse ($uploads as $upload)
                    <tr>
                        <td><a href="{{URL::to('uploads/'.$upload->id.'/show')}}">{{ $upload->titulo }}</a></td>
                        
                        <td><a href="{{URL::to('uploads/'.$upload->id.'/show')}}" class="btn btn-primary"><i class="fa fa-eye"></i>Visualizar</a></td>            
                        
                    </tr>                
                    @empty

                    <tr>
                        <td>
                            <span class="btn btn-primary">
                                <i class="fa fa-archive"></i>
                                 Nenhum arquivo relacionado.
                            </span>
                        </td>
                        
                    </tr>
                        
                    @endforelse            
                    
                </table>
            </div>
            <!-- /.box-body -->
        
        </div>

    </section>


    <section class="content">

        <div class="form-group col-md-12">
            <div class="box-header">
                <h3 class="box-title">Tutoriais Relacionados</h3>
        
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Titulo</th>
                        <th>Palavras Chave</th>
                        <th>Conteúdo</th>
                        <th>Ver</th>
                    </tr>
                    @forelse ($tutorials as $tutorial)
                    <tr>
                        <td><a href="{{URL::to('tutorials/'.$setor->name.'/'.$tutorial->id.'/show')}}">{{ str_limit($tutorial->titulo, $limit = 40, $end = '...') }}</a></td>
                        <td><a href="{{URL::to('tutorials/'.$setor->name.'/'.$tutorial->id.'/show')}}">{{$tutorial->palavras_chave}}</a></td>
                        <td><a href="{{URL::to('tutorials/'.$setor->name.'/'.$tutorial->id.'/show')}}">{{ str_limit(strip_tags($tutorial->conteudo), $limit = 80, $end = '...') }}</a></td>
                        <td><a href="{{URL::to('tutorials/'.$setor->name.'/'.$tutorial->id.'/show')}}" class="btn btn-primary"><i class="fa fa-eye"></i>Visualizar</a></td>            
                        
                    </tr>                
                    @empty

                    <tr>
                        <td>
                            <a href="{{url('tutorials/'.$setor->name.'/create') }}" class="btn btn-primary">
                                <i class="fa fa-frown-o"></i>
                                 Nenhum tutorial relacionado a este tipo de Ticket. Aproveite e inicie um Tutorial.
                            </a>
                        </td>
                        
                    </tr>
                        
                    @endforelse            
                    
                </table>
            </div>
            <!-- /.box-body -->
        
        </div>

    </section>




    <a href="#main-header" class="btn btn-primary" style="float: right;"><span class="fa fa-arrow-up"></span></a>

  @endsection
@endcan
