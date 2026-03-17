@extends('layouts.auth')

@section('title', 'Vérifier votre Email')

@section('content')
<div class="auth-card">
    <!-- Logo -->
    <div class="auth-logo">
        <img src="{{ asset('theme/images/logo/logo.png') }}" alt="EduGest Logo">
    </div>

    <!-- Titres -->
    <div class="auth-title">Vérifier votre Email</div>
    <div class="auth-subtitle">Veuillez vérifier votre adresse e-mail</div>

    <!-- Contenu -->
    @if (session('resent'))
        <div style="background: rgba(0,212,170,0.1); border: 1px solid rgba(0,212,170,0.3); color: var(--accent2); padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-bottom: 24px;">
            Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
        </div>
    @endif

    <p style="color: var(--muted); font-size: 14px; margin-bottom: 16px;">
        Avant de continuer, veuillez vérifier votre e-mail pour un lien de vérification.
    </p>
    <p style="color: var(--muted); font-size: 14px; margin-bottom: 24px;">
        Si vous n'avez pas reçu le message :
        <form style="display: inline;" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" style="background: none; border: none; color: var(--accent); cursor: pointer; font-weight: 600; padding: 0; text-decoration: underline;">
                cliquez ici pour en demander un autre
            </button>
        </form>
    </p>

    <!-- Footer -->
    <div class="auth-footer">
        Vous avez changé d'avis ? <a href="{{ route('login') }}">Retour à la connexion</a>
    </div>
</div>
@endsection

