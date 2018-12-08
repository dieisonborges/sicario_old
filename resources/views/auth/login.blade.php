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

    <p class="login-box-msg">{{ __('Login') }}</p>

     <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
        @csrf

        <div class="form-group row">
            <label for="email" class="col-sm-3 col-form-label text-md-right">{{ __('E-Mail') }}</label>

            <div class="col-md-9">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-3 col-form-label text-md-right">{{ __('Senha') }}</label>

            <div class="col-md-9">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row">
            <div class="col-md-12 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Lembrar-me') }}
                    </label>
                </div>
            </div>
            <div style="width: 100%; height: 50px; display: block;"></div>
            <div class="col-md-12 offset-md-4">
                <button type="submit" class="btn btn-primary col-md-12">
                    {{ __('Login') }}
                </button>

                <div style="width: 100%; height: 50px; display: block;"></div>   

                <a class="btn btn-link col-md-6" href="{{ route('password.request') }}">
                    {{ __('Esqueceu sua senha?') }}
                </a>

                <a class="btn btn-link col-md-6" href="{{ route('register') }}">
                    {{ __('Cadastre-se') }}
                </a>
            </div>

        </div>
    </form>    


   

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
@endsection
