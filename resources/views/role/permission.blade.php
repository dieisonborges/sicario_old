@extends('layouts.app')
@section('title', 'Regras')
@section('content')


<h1>Role (Grupo) <b>{{$role->label}}</b></h1>
<h3>Id: <b>{{$role->id}}</b> Label: <b>{{$role->name}}</b></h3>

<br>

<form method="POST" action="{{action('RoleController@permissionUpdate')}}">
    @csrf
    <input type="hidden" name="role_id" value="{{$role->id}}">
    
    <!--
    <select name="permission_id">
        @forelse ($all_permissions as $all_permission)
            <option value="{{$all_permission->id}}">
                {{$all_permission->name}} | {{$all_permission->label}}
            </option>
        @empty
            <option>Nenhuma Opção</option>     
        @endforelse
    </select>
    -->

    <div class="form-group col-md-6">
        <label>Adicionar Permissão:</label>
        <select name="permission_id[]" class="form-control select2" multiple="multiple" data-placeholder="Selecione um ou mais permissões"
                style="width: 100%;" required="required">
                @forelse ($all_permissions as $all_permission)
                    <option value="{{$all_permission->id}}">
                        {{$all_permission->name}} | {{$all_permission->label}}
                    </option>
                @empty
                    <option>Nenhuma Opção</option>     
                @endforelse
                      
        </select>

    </div>
    <div class="form-group col-md-3">
        <label>Ao Grupo:</label>
        <span class="form-control">{{$role->name}} | <small>{{$role->label}}</small></span>
    </div>
    <div class="form-group col-md-3" style="margin-top: 25px;">   
        <input class="btn btn-success btn-md" type="submit" value="Adicionar">
    </div>
    
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
