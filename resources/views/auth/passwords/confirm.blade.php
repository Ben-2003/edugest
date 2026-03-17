@extends('layouts.auth')

@section('title', 'Confirmer le Mot de Passe')

@section('content')
<div class="auth-card">
    <!-- Logo -->
    <div class="auth-logo">
        <img src="{{ asset('theme/images/logo/logo.png') }}" alt="EduGest Logo">
    </div>

    <!-- Titres -->
    <div class="auth-title">Confirmer votre Mot de Passe</div>
    <div class="auth-subtitle">Veuillez confirmer votre mot de passe pour continuer</div>

    <!-- Formulaire -->
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

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

        <!-- Bouton -->
        <button type="submit" class="btn-login" style="margin-bottom: 24px;">
            Confirmer le mot de passe
        </button>
    </form>

    <!-- Footer -->
    <div class="auth-footer">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
        @endif
    </div>
</div>
@endsection

