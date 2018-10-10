@extends('layouts.app')
@section('title', 'Permissões')
@section('content')
<h1>Permissões  <a href="{{url('permissions/create')}}" class="btn btn-info btn-lg"><i class="fa fa-plus"> </i> Novo</a></h1>

    @if (session('status'))
        <div class="alert alert-success" permission="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="col-md-12">	

        <form method="POST" enctype="multipart/form-data" action="{{url('permissions/busca')}}">
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
        <h3 class="box-title">Responsive Hover Table</h3>
        
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Nome (Name)</th>
                <th>Rótulo (Label)</th>
                <th>Role (Grupo)</th>
                <th>Editar</th>
                <th>Excluir</th>
            </tr>
            @forelse ($permissions as $permission)
            <tr>
                <td>{{$permission->id}}</td>
                <td><a href="{{URL::to('permissions')}}/{{$permission->id}}">{{$permission->name}}</a></td>
                <td><a href="{{URL::to('permissions')}}/{{$permission->id}}">{{$permission->label}}</a></td>
                <td>
                    <a class="btn btn-primary btn-xs" href="{{URL::to('permission/'.$permission->id.'/roles')}}"><i class="fa fa-lock"></i> Role (Grupo Mãe)</a>
                </td>
                
                <td>
                    <a class="btn btn-warning btn-xs" href="{{URL::to('permissions/'.$permission->id.'/edit')}}"><i class="fa fa-edit"></i> Editar</a>
                </td>
                <td>

                    <form method="POST" action="{{action('PermissionController@destroy', $permission->id)}}" id="formDelete{{$permission->id}}">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <!--<button class="btn btn-danger btn-xs" >Excluir</button>-->
                        <!--<input type="submit" name="Excluir">-->

                        <a href="javascript:confirmDelete{{$permission->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Excluir</a>
                    </form> 

                    <script>
                       function confirmDelete{{$permission->id}}() {

                        var result = confirm('Tem certeza que deseja excluir?');

                        if (result) {
                                document.getElementById("formDelete{{$permission->id}}").submit();
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

            {{$permissions->links()}}      
            
        </table>
    </div>
    <!-- /.box-body -->

@endsection
