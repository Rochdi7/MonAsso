@extends('layouts.AuthLayout')

@section('title', 'Login')

@section('content')
<div class="auth-form">
    <div class="card my-5">
        <div class="card-body">
            <div class="text-center">
                <img src="{{ URL::asset('build/images/authentication/img-auth-login.png') }}" alt="auth image"
                    class="img-fluid mb-3">
                <h4 class="f-w-500 mb-1">Connectez-vous avec votre e-mail ou téléphone</h4>
                <p class="mb-3">
                    Vous n'avez pas encore de compte ?
                    <a href="{{ route('register') }}" class="link-primary ms-1">Créer un compte</a>
                </p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" name="login" id="login"
                        class="form-control @error('login') is-invalid @enderror"
                        placeholder="E-mail ou téléphone" value="{{ old('login') }}" required autofocus>
                    <label for="login">E-mail ou téléphone</label>
                    @error('login')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Mot de passe" required>
                    <label for="password">Mot de passe</label>
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
                        <label class="form-check-label text-muted" for="remember">Se souvenir de moi</label>
                    </div>
                    <a href="{{ route('password.request') }}">
                        <h6 class="f-w-400 mb-0">Mot de passe oublié ?</h6>
                    </a>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Connexion</button>
                </div>
            </form>

            
        </div>
    </div>
</div>
@endsection
