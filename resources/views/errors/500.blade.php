@extends('layouts.login')
@section('content')
<div class="login-box">
  
  <!-- /.login-logo -->
  <div class="login-box-body">

    <a href="/">
        <b style="display:none;">SICARIO</b>
        <img src="{{ asset('img/logo/logo-branco-preto.jpg') }}" width="100%">
    </a>

    <hr>

    @include('layouts.error')

    
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Erro: 500 </h4>

        <h2><i class="fa fa-bug"></i> Todo mundo erra um dia, e hoje parece que foram nossos servidores... :(</h2>
        

        <br>
        <small>Whoops, looks like something went wrong</small>
        <br>
        <small>Opa, parece que algo deu errado</small>
    </div>

    <a class="btn btn-primary" href="javascript:history.go(-1)">Voltar</a>

       


   

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
