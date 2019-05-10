@extends('layouts.login')
@section('content')
<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="login-box-body">

    <a href="/">
        <b style="display:none;">{{ config('app.name') }}</b>
        <img src="{{ asset('img/logo/logo-branco-preto.jpg') }}" width="100%">
    </a>

    <hr>

    @include('layouts.error')

    
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Erro: 419 </h4>

        <h2><i class="fa fa-bug"></i> 
        A página expirou devido a inatividade. por favor atualize e tente novamente</h2>
        

        <br>
        <small>the page has expired due to inactivity.</small>
        <br>
        <small>please refresh and try again</small>
    </div>

    <a class="btn btn-primary" href="javascript:history.go(-1)">Voltar</a>

       


   

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
