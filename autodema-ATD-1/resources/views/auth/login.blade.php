@extends('layouts.app', ['page' => 'login'])

@section('content')
<div class="container-fluid d-flex h-100">
    <div class="row d-flex flex-wrap flex-grow-1">
        <div class="col-sm-7 d-flex justify-content-center flex-wrap align-items-center col-welcome-brand" style="background-color:#fff;">
            <img class="logo-login" src="{{ asset('image/logo autodema.png') }}" alt="logo">
            <img class="logo-login" src="{{ asset('image/logo_lvca.png') }}" alt="logo">
        </div>
        <div class="col-sm-5 d-flex justify-content-center align-items-center col-welcome-login">

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Ingrese su correo" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-12">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Ingrese  su contraseña" autocomplete="current-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-12 justify-content-center">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Ingresar') }}
                        </button>

                        @if (Route::has('password.request'))
                        <a class="btn btn-link link-white" href="{{ route('password.request') }}">
                            {{ __('Olvidé mi contraseña') }}
                        </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
