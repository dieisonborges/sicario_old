@extends('layouts.app')
@section('title', $permission->name)
@section('content')
	<h1>
        Permission - Rótulo - Regra
        <small>{{$permission->name}}</small>
    </h1>
	<div class="row">		
		<div class="col-md-6">
			<ul>
				<li><strong>ID: </strong> {{$permission->id}}</li>
				<li><strong>Nome: </strong> {{$permission->name}}</li>
				<li><strong>Rótulo(label): </strong> {{$permission->label}}</li>				
			</ul>	
		</div> 

	</div>
	
	
	<a href="javascript:history.go(-1)">Voltar</a>
@endsection