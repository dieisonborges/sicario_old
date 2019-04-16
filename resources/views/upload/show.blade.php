@extends('layouts.app')
@section('title', $upload->name)
@section('content')
	<h1>
        Upload
        <small>{{$upload->name}}</small>
    </h1>
	<div class="row">		
		<div class="col-md-6">
			<ul>
				<li><strong>ID: </strong> {{$upload->id}}</li>
				<li><strong>Nome: </strong> {{$upload->name}}</li>
				<li><strong>Rótulo(label): </strong> {{$upload->label}}</li>				
			</ul>	
		</div>

	</div>
	
	
	<a href="javascript:history.go(-1)">Voltar</a>
@endsection