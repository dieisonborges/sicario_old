@extends('layouts.app')
@section('title', 'Regras')
@section('content')


<h1>Role (Grupo) <b>{{$role->label}}</b></h1>
<h3>Id: <b>{{$role->id}}</b> Label: <b>{{$role->name}}</b></h3>

<br>

<form method="POST" action="{{action('RoleController@permissionUpdate')}}">
    @csrf
    <input type="hidden" name="role_id" value="{{$role->id}}">
    <label>Adicionar Permissão:</label>
    <select name="permission_id">
        @forelse ($all_permissions as $all_permission)
            <option value="{{$all_permission->id}}">
                {{$all_permission->name}} | {{$all_permission->label}}
            </option>
        @empty
            <option>Nenhuma Opção</option>     
        @endforelse
    </select>
    <label>Ao Grupo:</label>
    <span>{{$role->name}} | <small>{{$role->label}}</small></span>
    <input class="btn btn-success btn-sm" type="submit" value="Adicionar">
</form>


<br><br><br>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    
    <div class="box-header">
        <h3 class="box-title">Permissions:</h3>        
    </div>

    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Nome (Name)</th>
                <th>Rótulo (Label)</th>
                <th>Excluir</th>
            </tr>


            @forelse ($permissions as $permission)
            <tr>
                <td>{{$permission->id}}</td>
                <td>{{$permission->name}}</td>
                <td>{{$permission->label}}</td>
                
                <td>

                    <form method="POST" action="{{action('RoleController@permissionDestroy')}}" id="formDeleteP{{$permission->id}}">
                        @csrf
                        <input type="hidden" name="role_id" value="{{$role->id}}">
                        <input type="hidden" name="permission_id" value="{{$permission->id}}">
                        <!--<button class="btn btn-danger btn-xs" >Excluir</button>-->
                        <!--<input type="submit" name="Excluir">-->

                        <a href="javascript:confirmDeleteP{{$permission->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Excluir</a>
                    </form> 

                    <script>
                       function confirmDeleteP{{$permission->id}}() {

                        var result = confirm('Tem certeza que deseja excluir?');

                        if (result) {
                                document.getElementById("formDeleteP{{$permission->id}}").submit();
                          } else {
                                return false;
                            }
                        } 
                    </script>

                </td>
            </tr>                
            @empty
                
            @endforelse            
            
        </table>
    </div>
    <!-- /.box-body -->
   

@endsection
