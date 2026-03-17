@extends('layouts.auth')

@section('title', 'Créer un Compte')

@section('content')
<div class="auth-card">
    <!-- Logo -->
    <div class="auth-logo">
        <img src="{{ asset('theme/images/logo/logo.png') }}" alt="EduGest Logo">
    </div>

    <!-- Titres -->
    <div class="auth-title">Créer un Compte</div>
    <div class="auth-subtitle">Inscrivez-vous pour accéder à EduGest</div>

    <!-- Formulaire d'inscription -->
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nom complet -->
        <div class="form-group">
            <label for="name">Nom complet</label>
            <input 
                id="name" 
                type="text" 
                name="name" 
                placeholder="Jean Dupont"
                value="{{ old('name') }}" 
                class="@error('name') is-invalid @enderror"
                required 
                autocomplete="name" 
                autofocus
            >
            @error('name')
                <span class="invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

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

        <!-- Bouton d'inscription -->
        <button type="submit" class="btn-login" style="margin-bottom: 24px;">
            Créer mon compte
        </button>
    </form>

    <!-- Footer -->
    <div class="auth-footer">
        J'ai déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
    </div>
</div>
@endsection

