@extends('layouts.nologin')
@section('content')
	<div class="row">
		<table class="table table-bordered">
		  <tbody>
		  	<tr>
		      <td>
		      	<h1>SICARIO</h1>
		      	<br>
		      	<h3>Sistema de Controle, Análise e Relatório de Informação Operacional</h3>
		      </td>
		    </tr>
		    <tr>
		    	<td></td>
		    </tr>
		    <tr>
		      <td>{{$nome}}</td>
		    </tr>
		    <tr>
		    	<td></td>
		    </tr>
		    <tr>
		      <td>{{$email}}</td>
		    </tr>
		    <tr>
		    	<td></td>
		    </tr>
		    <tr>
		      <td>{{$assunto}}</td>
		    </tr>
		    <tr>
		    	<td></td>
		    </tr>
		    <tr>
		      <td>{!!html_entity_decode($msg)!!}</td>
		    </tr>
		    <tr>
		    </tr>
		  </tbody>
		</table>
	</div>
	
@endsection