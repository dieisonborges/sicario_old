@extends('layouts.app')
@section('title', 'Setor')
@section('content')
<h1>Setor de Trabalho<a href="{{url('setors/create')}}" class="btn btn-info btn-lg"><i class="fa fa-plus"> </i> Novo</a></h1>

    @if (session('status'))
        <div class="alert alert-success" setor="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-12">	

        <form method="POST" enctype="multipart/form-data" action="{{url('setors/busca')}}">
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
        <h3 class="box-title">Setores</h3>
        
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Nome (Name)</th>
                <th>Rótulo (Label)</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
            @forelse ($setors as $setor)
            <tr>
                <td><a href="{{URL::to('setors')}}/{{$setor->id}}">{{$setor->id}}</a></td>
                <td><a href="{{URL::to('setors')}}/{{$setor->id}}">{{$setor->name}}</a></td>
                <td><a href="{{URL::to('setors')}}/{{$setor->id}}">{{$setor->label}}</a></td>                
                <td>
                    <a class="btn btn-warning btn-xs" href="{{URL::to('setors/'.$setor->id.'/edit')}}"><i class="fa fa-edit"></i> Editar</a>
                </td>
                <td>

                    <form method="POST" action="{{action('SetorController@destroy', $setor->id)}}" id="formDelete{{$setor->id}}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <!--<button class="btn btn-danger btn-xs" >Excluir</button>-->
                        <!--<input type="submit" name="Excluir">-->

                        <a href="javascript:confirmDelete{{$setor->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Excluir</a>
                    </form> 

                    <script>
                       function confirmDelete{{$setor->id}}() {

                        var result = confirm('Tem certeza que deseja excluir?');

                        if (result) {
                                document.getElementById("formDelete{{$setor->id}}").submit();
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
    {{$setors->links()}}

@endsection
