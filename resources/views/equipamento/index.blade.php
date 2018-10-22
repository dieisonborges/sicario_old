@can('read_equipamento')    
    @extends('layouts.app')
    @section('title', 'Equipamentos')
    @section('content')    
    <h1>Equipamentos <a href="{{url('equipamentos/create')}}" class="btn btn-info btn-lg"><i class="fa fa-plus"> </i> Novo</a>  </h1>



        <div class="col-md-12">	

            <form method="POST" enctype="multipart/form-data" action="{{url('equipamentos/busca')}}">
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
            <h3 class="box-title">Gerência de Equipamentos</h3>
            
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Part Number</th>
                    <th>Serial Number</th>
                    <th>Descrição</th>
                    <th>Criado em:</th>
                    <th>Modificado em:</th>
                    <th>Sistema</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
                @forelse ($equipamentos as $equipamento)
                <tr>
                    <td>{{$equipamento->id}}</td>
                    <td><a href="{{URL::to('equipamentos')}}/{{$equipamento->id}}">{{$equipamento->nome}}</a></td>
                    <td><a href="{{URL::to('equipamentos')}}/{{$equipamento->id}}">{{$equipamento->part_number}}</a></td>
                    <td><a href="{{URL::to('equipamentos')}}/{{$equipamento->id}}">{{$equipamento->serial_number}}</a></td>
                    <td><a href="{{URL::to('equipamentos')}}/{{$equipamento->id}}">{{$equipamento->descricao}}</a></td>
                    <td><a href="{{URL::to('equipamentos')}}/{{$equipamento->id}}">{{$equipamento->created_at}}</a></td>
                    <td><a href="{{URL::to('equipamentos')}}/{{$equipamento->id}}">{{$equipamento->updated_at}}</a></td>
                    <td><a href="{{URL::to('equipamentos')}}/{{$equipamento->id}}">{{$equipamento->sistema_id}}</a></td>                    
                    <td>
                        <a class="btn btn-warning btn-xs" href="{{URL::to('equipamentos/'.$equipamento->id.'/edit')}}"><i class="fa fa-edit"></i> Editar</a>
                    </td>
                    <td>

                        <form method="POST" action="{{action('EquipamentoController@destroy', $equipamento->id)}}" id="formDelete{{$equipamento->id}}">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE">
                            <!--<button class="btn btn-danger btn-xs" >Excluir</button>-->
                            <!--<input type="submit" name="Excluir">-->

                            <a href="javascript:confirmDelete{{$equipamento->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Excluir</a>
                        </form> 

                        <script>
                           function confirmDelete{{$equipamento->id}}() {

                            var result = confirm('Tem certeza que deseja excluir?');

                            if (result) {
                                    document.getElementById("formDelete{{$equipamento->id}}").submit();
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

        {{$equipamentos->links()}}

    @endsection
@endcan
