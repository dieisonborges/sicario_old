@extends('layouts.app')
@section('title', 'Lista de Nicho')
@section('content')
	<h1>Nichos</h1>
	
	<div class="box-header">
        <h3 class="box-title">Lista de Nichos</h3>
        
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Nome do Nicho</th>
                <th>Descrição</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
            @forelse ($nichos as $nicho)
            <tr>
                <td>{{$nicho->id}}</td>
                <td><a href="{{URL::to('nichos')}}/{{$nicho->id}}">{{$nicho->nome}}</a></td>
                <td>{{$nicho->descricao}}</a></td>
                <td>
                    <a class="btn btn-warning btn-xs" href="{{URL::to('nichos/'.$nicho->id.'/edit')}}"><i class="fa fa-edit"></i> Editar</a>
                </td>
                <td>

                    <form method="POST" action="{{action('NichoController@destroy', $nicho->id)}}" id="formDelete{{$nicho->id}}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <a href="javascript:confirmDelete{{$nicho->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Excluir</a>
                    </form> 

                    <script>
                       function confirmDelete{{$nicho->id}}() {

                        var result = confirm('Tem certeza que deseja excluir?');

                        if (result) {
                                document.getElementById("formDelete{{$nicho->id}}").submit();
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



@endsection