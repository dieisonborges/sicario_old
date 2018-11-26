@can('read_tecnico')    
    @extends('layouts.app')
    @section('title', 'Livros')
    @section('content')    
    <h1>Livros de Serviço</h1>

        <div class="col-md-12"> 

            <form method="POST" enctype="multipart/form-data" action="{{url('livros/'.$setor->name.'/busca')}}">
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
            <h3 class="box-title">{{$setor->label}} <small>Gerência de Livros</small></h3>

            
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>ID</th>
                    <th>Protocolo</th>
                    <th>Responsável</th>
                    <th>Autenticação</th>
                    <th>Início do Serviço</th>
                    <th>Término do Serviço</th>                    
                </tr>
                @forelse ($livros as $livro)
                <tr>
                    <td>{{$livro->id}}</td>
                    <td><a href="{{URL::to('livros')}}/{{$setor->name}}/{{$livro->id}}/show">{{$livro->protocolo}}</a></td>                    
                    <td><a href="{{URL::to('livros')}}/{{$setor->name}}/{{$livro->id}}/show">{{$livro->users->name}}</a></td>
                    <td><a href="{{URL::to('livros')}}/{{$setor->name}}/{{$livro->id}}/show">{{$livro->autenticacao}}</a></td>
                    <td><a href="{{URL::to('livros')}}/{{$setor->name}}/{{$livro->id}}/show">{{date('d/m/Y h:i:s', strtotime($livro->inicio))}}
                    {{date('l', strtotime($livro->inicio))}}
                    </a></td>
                    <td><a href="{{URL::to('livros')}}/{{$setor->name}}/{{$livro->id}}/show">
                    {{date('d/m/Y h:i:s', strtotime($livro->fim))}}
                    {{date('l', strtotime($livro->fim))}}
                    </a></td>
                @empty
                    
                @endforelse            
                
            </table>
        </div>
        <!-- /.box-body -->

        {{$livros->links()}}

    @endsection
@endcan
