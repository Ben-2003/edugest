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
    <div class="auth-subtitle">Entrez votre adresse email pour recevoir un lien de réinitialisation</div>

    <!-- Message de succès -->
    @if (session('status'))
        <div style="background: rgba(0,212,170,0.1); border: 1px solid rgba(0,212,170,0.3); color: var(--accent2); padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 24px;">
            {{ session('status') }}
        </div>
    @endif

    <!-- Formulaire -->
    <form method="POST" action="{{ route('password.email') }}">
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

        <!-- Bouton -->
        <button type="submit" class="btn-login" style="margin-bottom: 24px;">
            Envoyer le lien de réinitialisation
        </button>
    </form>

    <!-- Footer -->
    <div class="auth-footer">
        Vous vous souvenez du mot de passe ? <a href="{{ route('login') }}">Se connecter</a>
    </div>
</div>
@endsection
