@can('read_tecnico')
    @extends('layouts.app')
    @section('title', 'Regras')
    @section('content')

    <h1>Setor de Trabalho <b>{{$setor->label}}</b></h1>


        <br><br>

        <div class="box box-primary col-lg-3">
            <br>
            <h2 class="box-title">Setor: <b>{{$setor->name}}</b></h2>
            <br>
            <h2 class="box-title"><b>{{$setor->label}}</b></h2>
            <br><br>
        </div>

        <form method="POST" action="{{action('TecnicoController@userUpdate')}}">
            @csrf
            <input type="hidden" name="setor_id" value="{{$setor->id}}">
            <div class="col-md-7">
                <label>Adicionar usuário:</label>
            
                <select name="user_id[]" class="form-control select2" multiple="multiple" data-placeholder="Selecione um ou mais técnicos para o setor" required="required">
                    @forelse ($users as $user)
                        <option value="{{$user->id}}">
                            {{$user->cargo}} {{$user->name_principal}} | {{$user->name}}
                        </option>
                    @empty
                        <option>Nenhuma Opção</option>     
                    @endforelse
                </select>
            </div>
            <div class="col-md-4">
                <label>Ao Setor:</label>
                <span class="form-control">{{$setor->name}}</span>
            </div>
            <div class="col-md-1" style="padding-top: 5px;">
                <br>
                <input class="btn btn-success" type="submit" value="Adicionar">
            </div>
          

        </form>

        <hr class="col-md-12 hr">

        <br>

        <div class="row">

            <div class="col-md-12">

            
                <div class="box-header">
                    <h3 class="box-title">Equipe cadastrada: </h3>        
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tr>
                            <th>ID</th>
                            <th colspan="2" >Nome Principal</th>
                            <th>Nome</th>
                            <th>Excluir</th>
                        </tr>


                        @forelse ($equipe as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->cargo}}</td>
                            <td>{{$user->name_principal}}</td>
                            <td>{{$user->name}}</td>

                            
                            
                            <td>

                                <form method="POST" action="{{action('TecnicoController@userDestroy')}}" id="formDelete{{$user->id}}">
                                    @csrf
                                    <input type="hidden" name="setor_id" value="{{$setor->id}}">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">
                                    <!--<button class="btn btn-danger btn-xs" >Excluir</button>-->
                                    <!--<input type="submit" name="Excluir">-->

                                    <a href="javascript:confirmDelete{{$user->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Remover</a>
                                </form> 

                                <script>
                                   function confirmDelete{{$user->id}}() {

                                    var result = confirm('Tem certeza que deseja excluir?');

                                    if (result) {
                                            document.getElementById("formDelete{{$user->id}}").submit();
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
            </div>
        </div>
       

    @endsection
@endcan
