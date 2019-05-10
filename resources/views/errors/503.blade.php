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
        <h4><i class="icon fa fa-ban"></i> Erro: 503 </h4>

        <h2><i class="fa fa-bug"></i>Ooops, ocorreu um erro no servidor. Por favor, verifique novamente mais tarde </h2>
        
        <br>
        <small>Serviço indisponível</small>
        <br>
        <small>Service Unavailable.</small>
        <br>
        <small>Ooops, server error occurred. Please check again later.</small>
    </div>

    <a class="btn btn-primary" href="javascript:history.go(-1)">Voltar</a>

       


   

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection