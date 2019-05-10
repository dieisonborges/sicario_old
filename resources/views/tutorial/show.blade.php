@extends('layouts.app')
@section('title', $tutorial->name)
@section('content')
	<h1>
        Tutorial:
        <small> {{$tutorial->titulo}}</small>
    </h1>
    <section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box-body col-md-4">              
		              <div class="callout callout-info">                
		                <h5>Criado em: <b>{{date('d/m/Y H:i:s', strtotime($tutorial->created_at))}}</b></h5>
		                <h5>Última edição: <b>{{date('d/m/Y H:i:s', strtotime($tutorial->updated_at))}}</b></h5>
		                <h5>Palavras chave: <b>{{$tutorial->palavras_chave}}</b></h5>
		              </div>
		        </div>		
				<div class="col-md-12 box">
					<br>
					{!!html_entity_decode($tutorial->conteudo)!!}
					<br>
				</div>
			</div>

		</div>
		<br>
		

		<a  class="btn btn-success btn-md" href="javascript:history.go(-1)"><span class="fa fa-arrow-left"></span> Voltar</a>

		<a  class="btn btn-warning btn-md" href="{{URL::to('tutorials/'.$setor.'/'.$tutorial->id.'/edit')}}"><i class="fa fa-edit"></i> Editar Tutorial</a>

		<a  class="btn btn-info btn-md" style="float: right;" href="{{URL::to('tutorials/'.$setor.'/'.$tutorial->id.'/setors')}}"><i class="fa fa-group"></i> Setores Vinculados Ao Tutorial</a>

		<hr class="hr"> 
		<br>
	</section>



	<section class="content">

        <div class="form-group col-md-12">
            <div class="box-header">
            <h3 class="box-title">Arquivos: </h3>

            <a href="{{URL::to('uploads')}}/{{$tutorial->id}}/create/tutorial"  class="btn btn-info btn-md" style="float: right;"><i class="fa fa-plus-circle"></i> Novo Arquivo</a>
            
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Titulo</th>
                        <th>Nome</th>
                        <th>Tamanho</th>
                        <th>Tipo</th>
                        <th>Ver</th>
                        <th>Excluir</th>
                    </tr>
                    @forelse ($uploads as $upload)
                    <tr>
                        <td><a href="{{ url('storage/'.$upload->dir.'/'.$upload->link) }}" target="_blank">{{ $upload->link }}</a> </td>
                        <td><a href="{{ url('storage/'.$upload->dir.'/'.$upload->link) }}" target="_blank">{{ $upload->titulo }}</a></td>
                        <td><a href="{{ url('storage/'.$upload->dir.'/'.$upload->link) }}" target="_blank">{{ $upload->nome }}</a></td>
                        <td><a href="{{ url('storage/'.$upload->dir.'/'.$upload->link) }}" target="_blank">{{ number_format(($upload->tam/1000), 2, ',', '') }} kbytes</a></td>
                        <td><a href="{{ url('storage/'.$upload->dir.'/'.$upload->link) }}" target="_blank">{{ $upload->tipo }}</a></td>
                        <td><a href="{{ url('storage/'.$upload->dir.'/'.$upload->link) }}" target="_blank" class="btn btn-primary"><i class="fa fa-eye"></i> Visualizar</a></td>                       

                        <td>
                            <form method="POST" action="{{url('uploads/destroy', $upload->id)}}" id="formDelete{{$upload->id}}">
                                @csrf
                                <input type="hidden" name="id" value="{{$upload->id}}">                                

                                <a href="javascript:confirmDelete{{$upload->id}}();" class="btn btn-danger"> <i class="fa fa-close"></i></a>
                            </form> 

                            <script>
                               function confirmDelete{{$upload->id}}() {

                                var result = confirm('Tem certeza que deseja excluir?');

                                if (result) {
                                        document.getElementById("formDelete{{$upload->id}}").submit();
                                    } else {
                                        return false;
                                    }
                                } 
                            </script>

                        </td>      
                        
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

@endsection