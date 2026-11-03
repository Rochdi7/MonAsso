@extends('layouts.AuthLayout')

@section('title', 'Login')

@section('content')
<div class="auth-form">
    <div class="card my-5">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ URL::asset('build/images/authentication/img-auth-login.png') }}" alt="auth image"
                    class="img-fluid mb-3">
                <h4 class="f-w-500 mb-1">Acesse sua conta</h4>
                <p class="mb-3">Use o e-mail ou telefone cadastrado no clube.</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" name="login" id="login"
                        class="form-control @error('login') is-invalid @enderror"
                        placeholder="E-mail ou telefone" value="{{ old('login') }}" required autofocus>
                    <label for="login">E-mail ou telefone</label>
                    @error('login')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Senha" required>
                    <label for="password">Senha</label>
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-flex mt-1 justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input input-primary" type="checkbox" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-muted" for="remember">Lembrar de mim</label>
                    </div>
                    <a href="{{ route('password.request') }}">
                        <h6 class="f-w-400 mb-0">Esqueci minha senha</h6>
                    </a>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
