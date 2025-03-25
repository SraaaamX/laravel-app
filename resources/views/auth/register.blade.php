@extends('layouts.app')

@section('content')
    <div class="register-container">
        <div class="register-box">
            <div class="register-header">
                <h2>Créer un compte</h2>
                <p>Rejoignez notre communauté</p>
            </div>

            <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data" class="register-form">
                @csrf

                <div class="form-columns">
                    <div class="form-column">
                        <!-- Username -->
                        <div class="form-group">
                            <label>Nom d'utilisateur</label>
                            <input type="text" class="form-input @error('username') is-invalid @enderror" name="username"
                                value="{{ old('username') }}" required>
                            @error('username')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Adresse email</label>
                            <input type="email" class="form-input @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <label>Mot de passe</label>
                            <input type="password" class="form-input @error('password') is-invalid @enderror"
                                name="password" required>
                            @error('password')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Confirmation -->
                        <div class="form-group">
                            <label>Confirmer le mot de passe</label>
                            <input type="password" class="form-input" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-column">
                        <!-- Profile Picture -->
                        <div class="form-group">
                            <label>Photo de profil</label>
                            <input type="file" class="form-input @error('profile_pic') is-invalid @enderror"
                                name="profile_pic" accept="image/*">
                            <small class="help-text">Format JPG, PNG, WEBP (max 2MB)</small>
                            @error('profile_pic')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="form-group">
                            <label>Biographie</label>
                            <textarea class="form-input @error('bio') is-invalid @enderror" name="bio" rows="4">{{ old('bio') }}</textarea>
                            <small class="help-text">Présentez-vous en quelques mots</small>
                            @error('bio')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Créer mon compte</button>
                </div>
            </form>

            <div class="login-prompt">
                <p>Déjà inscrit ? <a href="{{ route('login') }}" class="login-link">Connectez-vous</a></p>
            </div>
        </div>
    </div>

    <style>
        .register-container {
            width: 980px;
            margin: 20px auto;
            display: flex;
            justify-content: center;
        }

        .register-box {
            background: white;
            border: 1px solid var(--facebook-border);
            width: 700px;
            padding: 0;
        }

        .register-header {
            background: var(--facebook-light-blue);
            padding: 8px 10px;
            border-bottom: 1px solid var(--facebook-border);
        }

        .register-header h2 {
            color: var(--facebook-text);
            font-size: 13px;
            font-weight: bold;
            margin: 0 0 4px 0;
        }

        .register-header p {
            color: var(--facebook-text);
            font-size: 11px;
            margin: 0;
        }

        .register-form {
            padding: 15px;
        }

        .form-columns {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }

        .form-column {
            flex: 1;
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
            background: #ffebe8;
        }

        .error-text {
            color: var(--danger);
            font-size: 11px;
            margin-top: 2px;
        }

        .help-text {
            display: block;
            color: #666;
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

        .login-prompt {
            background: var(--facebook-light-blue);
            border-top: 1px solid var(--facebook-border);
            padding: 10px;
            text-align: center;
        }

        .login-prompt p {
            margin: 0;
            font-size: 11px;
            color: var(--facebook-text);
        }

        .login-link {
            color: var(--facebook-link);
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 60px;
        }
    </style>
@endsection
