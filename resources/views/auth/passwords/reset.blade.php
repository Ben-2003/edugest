@extends('layouts.auth')

@section('title', 'Réinitialiser le Mot de Passe')

@section('content')
<div class="auth-card">
    <!-- Logo -->
    <div class="auth-logo">
        <img src="{{ asset('theme/images/logo/logo.png') }}" alt="EduGest Logo">
    </div>

    <!-- Titres -->
    <div class="auth-title">Réinitialiser le Mot de Passe</div>
    <div class="auth-subtitle">Entrez votre nouveau mot de passe</div>

    <!-- Formulaire -->
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email -->
        <div class="form-group">
            <label for="email">Adresse E-mail</label>
            <input 
                id="email" 
                type="email" 
                name="email" 
                placeholder="exemple@ecole.com"
                value="{{ $email ?? old('email') }}" 
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

        <!-- Nouveau mot de passe -->
        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input 
                id="password" 
                type="password" 
                name="password" 
                placeholder="••••••••"
                class="@error('password') is-invalid @enderror"
                required 
                autocomplete="new-password"
            >
            @error('password')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <!-- Confirmer le mot de passe -->
        <div class="form-group">
            <label for="password-confirm">Confirmer le mot de passe</label>
            <input 
                id="password-confirm" 
                type="password" 
                name="password_confirmation" 
                placeholder="••••••••"
                class="@error('password') is-invalid @enderror"
                required 
                autocomplete="new-password"
            >
        </div>

        <!-- Bouton -->
        <button type="submit" class="btn-login" style="margin-bottom: 24px;">
            Réinitialiser le mot de passe
        </button>
    </form>

    <!-- Footer -->
    <div class="auth-footer">
        Vous vous souvenez du mot de passe ? <a href="{{ route('login') }}">Se connecter</a>
    </div>
</div>
@endsection
