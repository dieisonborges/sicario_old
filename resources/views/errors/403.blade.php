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
        <h4><i class="icon fa fa-ban"></i> Erro: 403</h4>
        <h5>Unauthorized</h5>
        Desculpe, mas você não tem autorização para acessar essa página.
        <br><br>
        <small>Sorry, you do not have permission to access this page.</small>
    </div>

    <a class="btn btn-default" href="javascript:history.go(-1)"><span class="fa fa-arrow-left"></span> Voltar</a>

    <a class="btn btn-default" href="{{url('/')}}" style="float: right;"><span class="fa fa-home"></span> Login</a>

    
   

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
