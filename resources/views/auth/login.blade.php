@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<div class="auth-card">
    <!-- Logo -->
    <div class="auth-logo">
        <img src="{{ asset('theme/images/logo/logo.png') }}" alt="EduGest Logo">
    </div>

    <!-- Titres -->
    <div class="auth-title">Connexion</div>
    <div class="auth-subtitle">Connectez-vous à votre compte EduGest</div>

    <!-- Formulaire de connexion -->
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email">Adresse E-mail</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                placeholder="exemple@ecole.com"
                value="{{ old('email') }}" 
                class="@error('email') is-invalid @enderror"
                required 
                autocomplete="email" 
                autofocus
            >
            @error('email')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Mot de passe -->
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                placeholder="••••••••"
                class="@error('password') is-invalid @enderror"
                required 
                autocomplete="current-password"
            >
            @error('password')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Se souvenir de moi & Mot de passe oublié -->
        <div class="form-actions">
            <div class="form-check">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    name="remember" 
                    id="remember" 
                    {{ old('remember') ? 'checked' : '' }}
                >
                <label class="form-check-label" for="remember">
                    Se souvenir de moi
                </label>
            </div>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">
                    Mot de passe oublié ?
                </a>
            @endif
        </div>

        <!-- Bouton Connexion -->
        <button type="submit" class="btn-login">
            Connexion
        </button>
    </form>

    <!-- Footer -->
    <div class="auth-footer" style="margin-top: 24px;">
        Pas encore inscrit ? <a href="{{ route('register') }}">Créer un compte</a>
    </div>
</div>
@endsection

