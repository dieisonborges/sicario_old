@extends('layouts.app')
@section('title', 'Regras')
@section('content') 

<h1>Permission <b>{{$permission->label}}</b></h1>
<h3>Id: <b>{{$permission->id}}</b> Label: <b>{{$permission->name}}</b></h3>
    
    <div class="box-header">
        <h3 class="box-title">Roles(Grupos) Mãe:</h3>
        
    </div>

    
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Nome (Name)</th>
                <th>Rótulo (Label)</th>
            </tr>


            @forelse ($roles as $role)
            <tr>
                <td>{{$role->id}}</td>
                <td>{{$role->name}}</td>
                <td>{{$role->label}}</td>
            </tr>                
            @empty
                
            @endforelse            
            
        </table>
    </div>
    <!-- /.box-body -->
   

@endsection
