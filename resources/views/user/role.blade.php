@can('update_user')  
    @extends('layouts.app')
    @section('title', 'Regras')
    @section('content')

    <h1>Usuários/Roles(Grupos)</h1>


        <br><br>

        <div class="box box-primary col-lg-3">
            <h2 class="box-title">Usuário: <b>{{$user->name}}</b></h2>
            <br>
            <h2 class="box-title">Email: <b>{{$user->email}}</b></h2>
            <br>
            <h2 class="box-title">CPF: <b>{{$user->cpf}}</b></h2>
        </div>

        <form method="POST" action="{{action('UserController@roleUpdate')}}">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <label>Adicionar Grupo (Role):</label>
            <select name="role_id">
                @forelse ($all_roles as $all_role)
                    <option value="{{$all_role->id}}">
                        {{$all_role->name}} | {{$all_role->label}}
                    </option>
                @empty
                    <option>Nenhuma Opção</option>     
                @endforelse
            </select>
            <label>Ao usuário:</label>
            <span>{{$user->id}} | <small>{{$user->name}}</small></span>
            <input class="btn btn-success btn-sm" type="submit" value="Adicionar">
        </form>

        
        <div class="box-header">
            <h3 class="box-title">Roles (Grupos): </h3>        
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


                @forelse ($roles as $role)
                <tr>
                    <td>{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>{{$role->label}}</td>

                    
                    
                    <td>

                        <form method="POST" action="{{action('UserController@roleDestroy')}}" id="formDelete{{$role->id}}">
                            @csrf
                            <input type="hidden" name="role_id" value="{{$role->id}}">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
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
                    
                @endforelse            
                
            </table>
        </div>
        <!-- /.box-body -->
       

    @endsection
@endcan
