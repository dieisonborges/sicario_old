@extends('layouts.app')
@section('title', $tutorial->name)
@section('content')
	<h1>
        Tutorial:
        <small> {{$tutorial->titulo}}</small>
    </h1>
	<div class="row">
		<div class="col-md-12">
			<div class="box-body col-md-4">              
	              <div class="callout callout-info">                
	                <h5>Criado em: <b>{{date('d/m/Y H:i:s', strtotime($tutorial->created_at))}}</b></h5>
	                <h5>Última edição: <b>{{date('d/m/Y H:i:s', strtotime($tutorial->updated_at))}}</b></h5>
	                <h5>Palavras chave: <b>{{$tutorial->palavras_chave}}</b></h5>
	              </div>
	        </div>		
			<div class="col-md-12 box">
				<br>
				{!!html_entity_decode($tutorial->conteudo)!!}
				<br>
			</div>
		</div>

	</div>
	<br>
	<hr class="hr">
	<br>

	<a  class="btn btn-success btn-md" href="javascript:history.go(-1)"><span class="fa fa-arrow-left"></span> Voltar</a>

	<a  class="btn btn-warning btn-md" href="{{URL::to('tutorials/'.$tutorial->id.'/edit')}}"><i class="fa fa-edit"></i> Editar Tutorial</a>

	<a  class="btn btn-info btn-md" style="float: right;" href="{{URL::to('tutorials/'.$tutorial->id.'/setors')}}"><i class="fa fa-group"></i> Setores Vinculados Ao Tutorial</a>

@endsection