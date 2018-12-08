@extends('layouts.nologin')
@section('content')

	<div class="row">
		<h4 class="mb-3">Contato SICARIO</h4>
		<table class="table table-bordered">
		  <tbody>
		  	<tr>
		      <td><h1>SICARIO</h1></td>
		      <td><h3>Sistema de Controle, Análise e Relatório de Informação Operacional</h3></td>
		    </tr>
		    <tr>
		      <td><strong>Nome:</strong></td>
		      <td>{{$nome}}</td>
		    </tr>
		    <tr>
		      <td><strong>Email:</strong></td>
		      <td>{{$email}}</td>
		    </tr>
		    <tr>
		      <td><strong>Assunto:</strong></td>
		      <td>{{$assunto}}</td>
		    </tr>
		    <tr>
		      <td><strong>Mensagem:</strong></td>
		      <td>{{$msg}}</td>
		    </tr>
		    <tr>
		    </tr>
		  </tbody>
		</table>
	</div>
	
@endsection