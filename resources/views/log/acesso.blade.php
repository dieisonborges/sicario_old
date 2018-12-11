@can('read_log')    
    @extends('layouts.app')
    @section('title', 'Logs')
    @section('content')    
    <h1>Logs (Registros) de Acesso do Sistema </h1>



        <div class="col-md-12">	

            <form method="POST" enctype="multipart/form-data" action="{{url('logs/busca')}}">
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
            <h3 class="box-title">Eventos do sistema</h3>
            
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive no-padding">
            <table class="table table-hover">
                <tr>
                    <th>IP</th>
                </tr>
                @forelse ($logs as $log)
                <tr>
                    <td><a href="#">{{$log->ip}}</a></td>                    
                </tr>                
                @empty
                    
                @endforelse            
                
            </table>
        </div>
        <!-- /.box-body -->

        {{$logs->links()}}

    @endsection
@endcan
