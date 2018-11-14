@can('read_user')    
    @extends('layouts.app')
    @section('title', 'Usuários')
    @section('content')    
    <h1>Usuários <a href="{{url('users/create')}}" class="btn btn-info btn-lg"><i class="fa fa-plus"> </i> Novo</a>  </h1>



        <div class="col-md-12">	

            <form method="POST" enctype="multipart/form-data" action="{{url('users/busca')}}">
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
            <h3 class="box-title">Gerência de Usuários</h3>
            
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Celular</th>
                    <th>Status</th>
                    <th>Login<br> (Max 15)</th>
                    <th>Desativar <br>Ativar</th>
                    <th>Roles <br> Grupo</th>
                    <th>Setor de <br> Trabalho</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
                @forelse ($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td><a href="{{URL::to('users')}}/{{$user->id}}">{{$user->name}}</a></td>
                    <td><a href="{{URL::to('users')}}/{{$user->id}}">{{$user->email}}</a></td>
                    <td><a href="{{URL::to('users')}}/{{$user->id}}">{{$user->cpf}}</a></td>
                    <td><a href="{{URL::to('users')}}/{{$user->id}}">{{$user->telefone}}</a></td>
                    <td>
                        @if ($user->status)
                            <span class="label label-success">ATIVO</span>                        
                        @else
                            <span class="label label-danger">INATIVO</span>
                        @endif
                    </td>
                    <td>
                        @if (($user->login)<=15)
                            <span class="label label-success">{{$user->login}}</span>
                        @else
                            <span class="label label-danger">{{$user->login}}</span>
                        @endif
                    </td>               
                    <td>                  

                        @if ($user->status)
                            <form method="POST" action="{{action('UserController@updateActive')}}">
                                @csrf    
                                <input type="hidden" name="status" value="0">
                                <input type="hidden" name="id" value="{{$user->id}}">                  
                                <input type="submit" class="btn btn-danger btn-xs" value="Desativar">
                            </form>                        
                        @else
                            <form method="POST" action="{{action('UserController@updateActive', $user->id)}}">
                                @csrf       
                                <input type="hidden" name="status" value="1">   
                                <input type="hidden" name="id" value="{{$user->id}}">                   
                                <input type="submit" class="btn btn-success btn-xs" value="Ativar">
                            </form>
                            
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-primary btn-xs" href="{{URL::to('user/'.$user->id.'/roles')}}"><i class="fa fa-lock"></i> Roles</a>
                    </td>
                    <td>
                        <a class="btn btn-primary btn-xs" href="{{URL::to('user/'.$user->id.'/setors')}}"><i class="fa fa-group"></i> Setor</a>
                    </td>
                    <td>
                        <a class="btn btn-warning btn-xs" href="{{URL::to('users/'.$user->id.'/edit')}}"><i class="fa fa-edit"></i> Editar</a>
                    </td>
                    <td>

                        <form method="POST" action="{{action('UserController@destroy', $user->id)}}" id="formDelete{{$user->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <!--<button class="btn btn-danger btn-xs" >Excluir</button>-->
                            <!--<input type="submit" name="Excluir">-->

                            <a href="javascript:confirmDelete{{$user->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Excluir</a>
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

        {{$users->links()}}

    @endsection
@endcan
