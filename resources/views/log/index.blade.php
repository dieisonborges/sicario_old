@can('read_log')    
    @extends('layouts.app')
    @section('title', 'Logs')
    @section('content')    
    <h1>Logs (Registros) do Sistema </h1>



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
                    <th>ID</th>
                    <th>IP</th>
                    <th>MAC</th>
                    <th>HOST</th>
                    <th>Filename</th>
                    <th>Info</th>
                    <th>User ID</th>
                    <th>Created at</th> 
                </tr>
                @forelse ($logs as $log)
                <tr>
                    <td>{{$log->id}}</td>
                    <td><a href="{{URL::to('logs')}}/{{$log->id}}">{{$log->ip}}</a></td>
                    <td><a href="{{URL::to('logs')}}/{{$log->id}}">{{$log->mac}}</a></td>
                    <td><a href="{{URL::to('logs')}}/{{$log->id}}">{{$log->host}}</a></td>
                    <td><a href="{{URL::to('logs')}}/{{$log->id}}">{{$log->filename}}</a></td>
                    <td><a href="{{URL::to('logs')}}/{{$log->id}}"> {{ str_limit($log->info, $limit = 40, $end = '...') }}</a></td>
                    <td><a href="{{URL::to('logs')}}/{{$log->id}}">{{$log->user_id}}</a></td>
                    <td><a href="{{URL::to('logs')}}/{{$log->id}}">{{date('d/m/Y H:i:s', strtotime($log->created_at))}}</a></td>
                    
                </tr>                
                @empty
                    
                @endforelse            
                
            </table>
        </div>
        <!-- /.box-body -->

        {{$logs->links()}}

    @endsection
@endcan
