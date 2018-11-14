@can('update_user')  
    @extends('layouts.app')
    @section('title', 'Regras')
    @section('content')

    <h1>Setor(es) de Trabalho do Usuário</h1>


        <br><br>

        <div class="box box-primary col-lg-3">
            <h2 class="box-title">Usuário: <b>{{$user->name}}</b></h2>
            <br>
            <h2 class="box-title">Email: <b>{{$user->email}}</b></h2>
            <br>
            <h2 class="box-title">CPF: <b>{{$user->cpf}}</b></h2>
        </div>

        <form method="POST" action="{{action('UserController@setorUpdate')}}">
            @csrf
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <label>Adicionar Setor:</label>
            <select name="setor_id">
                @forelse ($all_setors as $all_setor)
                    <option value="{{$all_setor->id}}">
                        {{$all_setor->name}} | {{$all_setor->label}}
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
            <h3 class="box-title">Setors: </h3>        
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


                @forelse ($setors as $setor)
                <tr>
                    <td>{{$setor->id}}</td>
                    <td>{{$setor->name}}</td>
                    <td>{{$setor->label}}</td>

                    
                    
                    <td>

                        <form method="POST" action="{{action('UserController@setorDestroy')}}" id="formDelete{{$setor->id}}">
                            @csrf
                            <input type="hidden" name="setor_id" value="{{$setor->id}}">
                            <input type="hidden" name="user_id" value="{{$user->id}}">
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
                    
                @endforelse            
                
            </table>
        </div>
        <!-- /.box-body -->
       

    @endsection
@endcan
