@extends('layouts.app')
@section('title', $role->name)
@section('content')
	<h1>
        Role - Rótulo - Regra
        <small>{{$role->name}}</small>
    </h1>
	<div class="row">		
		<div class="col-md-6">
			<ul>
				<li><strong>ID: </strong> {{$role->id}}</li>
				<li><strong>Nome: </strong> {{$role->name}}</li>
				<li><strong>Rótulo(label): </strong> {{$role->label}}</li>				
			</ul>	
		</div>

	</div>
	
	
	<a href="javascript:history.go(-1)">Voltar</a>
@endsection