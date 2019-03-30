@extends('layouts.app')
@section('title', 'Regras')
@section('content')
<h1>Tutoriais <a href="{{url('tutorials/'.$setor_atual.'/create')}}" class="btn btn-info btn-lg"><i class="fa fa-plus"> </i> Novo</a></h1>

    @if (session('status'))
        <div class="alert alert-success" tutorial="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-12">	

        <form method="POST" enctype="multipart/form-data" action="{{url('tutorials/'.$setor_atual.'/busca')}}">
            @csrf
            <div class="input-group input-group-lg">			
                <input type="text" class="form-control" id="busca" name="busca" placeholder="Procurar..." value="{{$buscar}}">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat">Buscar</button>
                    </span>

            </div>
        </form>

    </div>

    <br><br><br>

    
    <div class="box-header">
        <h3 class="box-title">Tutoriais</h3>
        
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Palavras Chave</th>
                <!--<th>Conteúdo</th>-->
                <th>Setores</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
            @forelse ($tutorials as $tutorial)
            <tr>
                <td><a href="{{URL::to('tutorials/'.$tutorial->id)}}">{{$tutorial->id}}</a></td>
                <td><a href="{{URL::to('tutorials/'.$tutorial->id)}}">{{ str_limit($tutorial->titulo, $limit = 40, $end = '...') }}</a></td>
                <td><a href="{{URL::to('tutorials/'.$tutorial->id)}}">{{$tutorial->palavras_chave}}</a></td>
                <!--<td><a href="{{URL::to('tutorials/'.$tutorial->id)}}">{{ str_limit($tutorial->conteudo, $limit = 40, $end = '...') }}</a></td>-->
                <td>
                    <a class="btn btn-primary btn-xs" href="{{URL::to('tutorials/'.$tutorial->id.'/setors')}}"><i class="fa fa-group"></i> Setores</a>
                </td>
                <td>
                    <a class="btn btn-warning btn-xs" href="{{URL::to('tutorials/'.$tutorial->id.'/edit')}}"><i class="fa fa-edit"></i> Editar</a>
                </td>
                <td>

                    <form method="GET" action="{{url('tutorials/'.$setor_atual.'/'.$tutorial->id.'/excluir')}}" id="formDelete{{$tutorial->id}}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="id" value="{{$tutorial->id}}">
                        <!--<button class="btn btn-danger btn-xs" >Excluir</button>-->
                        <!--<input type="submit" name="Excluir">-->

                        <a href="javascript:confirmDelete{{$tutorial->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Excluir</a>
                    </form> 

                    <script>
                       function confirmDelete{{$tutorial->id}}() {

                        var result = confirm('Tem certeza que deseja excluir?');

                        if (result) {
                                document.getElementById("formDelete{{$tutorial->id}}").submit();
                            } else {
                                return false;
                            }
                        } 
                    </script>

                </td>
            </tr>                
            @empty

            <tr>
                <td><b>Nenhum Resultado.</b></td>
            </tr>
                
            @endforelse            
            
        </table>
    </div>
    <!-- /.box-body -->
    {{$tutorials->links()}}

@endsection
