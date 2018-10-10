@extends('layouts.app')
@section('title', 'Regras')
@section('content')
<h1>Role - Grupo <a href="{{url('roles/create')}}" class="btn btn-info btn-lg"><i class="fa fa-plus"> </i> Novo</a></h1>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-12">	

        <form method="POST" enctype="multipart/form-data" action="{{url('roles/busca')}}">
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
        <h3 class="box-title">Role - Grupo - Papéis</h3>
        
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Nome (Name)</th>
                <th>Rótulo (Label)</th>
                <th>Permissions</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
            @forelse ($roles as $role)
            <tr>
                <td><a href="{{URL::to('roles')}}/{{$role->id}}">{{$role->id}}</a></td>
                <td><a href="{{URL::to('roles')}}/{{$role->id}}">{{$role->name}}</a></td>
                <td><a href="{{URL::to('roles')}}/{{$role->id}}">{{$role->label}}</a></td>
                <td>
                    <a class="btn btn-primary btn-xs" href="{{URL::to('role/'.$role->id.'/permissions')}}"><i class="fa fa-lock"></i> Permissions (filha)</a>
                </td>
                <td>
                    <a class="btn btn-warning btn-xs" href="{{URL::to('roles/'.$role->id.'/edit')}}"><i class="fa fa-edit"></i> Editar</a>
                </td>
                <td>

                    <form method="POST" action="{{action('RoleController@destroy', $role->id)}}" id="formDelete{{$role->id}}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <!--<button class="btn btn-danger btn-xs" >Excluir</button>-->
                        <!--<input type="submit" name="Excluir">-->

                        <a href="javascript:confirmDelete{{$role->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Excluir</a>
                    </form> 

                    <script>
                       function confirmDelete{{$role->id}}() {

                        var result = confirm('Tem certeza que deseja excluir?');

                        if (result) {
                                document.getElementById("formDelete{{$role->id}}").submit();
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
    {{$roles->links()}}

@endsection
