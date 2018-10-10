@extends('layouts.nologin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h1>{{ __('Reiniciar Senha') }}</h1></div>
                <br><br>
                
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" aria-label="{{ __('Reset Password') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-1 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-5">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                            <div class="col-md-4 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enviar o Link de Redefinição de Senha') }}
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            
        </div>
    </div>
</div>
@endsection
