@extends('layouts.app')

@section('content')
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h2>Connexion</h2>
                <p>Bienvenue sur notre réseau social</p>
            </div>

            <form method="POST" action="{{ route('login.submit') }}" class="login-form">
                @csrf
                @method('POST')

                <div class="form-group">
                    <label>Adresse email</label>
                    <input type="email" class="form-input @error('email') is-invalid @enderror" name="email"
                        value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nom d'utilisateur</label>
                    <input type="text" class="form-input @error('username') is-invalid @enderror" name="username"
                        value="{{ old('username') }}" required>
                    @error('username')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" class="form-input @error('password') is-invalid @enderror" name="password"
                        required>
                    @error('password')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>

            <div class="register-prompt">
                <p>Pas encore de compte ? <a href="{{ route('register') }}" class="register-link">Inscrivez-vous</a></p>
            </div>
        </div>
    </div>

    <style>
        .login-container {
            width: 980px;
            margin: 20px auto;
            display: flex;
            justify-content: center;
        }

        .login-box {
            background: white;
            border: 1px solid var(--facebook-border);
            width: 400px;
            padding: 0;
        }

        .login-header {
            background: var(--facebook-light-blue);
            padding: 8px 10px;
            border-bottom: 1px solid var(--facebook-border);
        }

        .login-header h2 {
            color: var(--facebook-text);
            font-size: 13px;
            font-weight: bold;
            margin: 0 0 4px 0;
        }

        .login-header p {
            color: var(--facebook-text);
            font-size: 11px;
            margin: 0;
        }

        .login-form {
            padding: 10px;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            color: var(--facebook-text);
            margin-bottom: 3px;
        }

        .form-input {
            width: 100%;
            padding: 3px;
            border: 1px solid #bdc7d8;
            font-size: 11px;
        }

        .form-input:focus {
            border-color: #3b5998;
        }

        .form-input.is-invalid {
            border-color: var(--danger);
        }

        .error-text {
            color: var(--danger);
            font-size: 11px;
            margin-top: 2px;
        }

        .form-actions {
            border-top: 1px solid var(--facebook-border);
            padding: 10px 0 0 0;
            margin-top: 10px;
        }

        .btn-primary {
            font-size: 11px;
            padding: 2px 6px;
            background: #5b74a8;
            background-image: linear-gradient(#637bad, #5872a7);
            border: 1px solid;
            border-color: #29447e #29447e #1a356e;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .register-prompt {
            background: var(--facebook-light-blue);
            border-top: 1px solid var(--facebook-border);
            padding: 10px;
            text-align: center;
        }

        .register-prompt p {
            margin: 0;
            font-size: 11px;
            color: var(--facebook-text);
        }

        .register-link {
            color: var(--facebook-link);
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }
    </style>
@endsection
