@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg rounded-4 border-0 overflow-hidden fade-in">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="mb-4">
                                <i class="bi bi-person-plus-fill" style="font-size: 3rem; color: var(--primary-color);"></i>
                            </div>
                            <h3 class="fw-bold mb-2" style="color: var(--primary-color);">Créer un compte</h3>
                            <p class="text-secondary mb-0">Rejoignez notre communauté</p>
                        </div>

                        <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data"
                            class="register-form">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Username -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-medium mb-2">Nom d'utilisateur</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-person"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control border-start-0 ps-0 @error('username') is-invalid @enderror"
                                                name="username" value="{{ old('username') }}"
                                                placeholder="Choisissez un pseudo" required>
                                        </div>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-medium mb-2">Adresse email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-envelope"></i>
                                            </span>
                                            <input type="email"
                                                class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" placeholder="Entrez votre email"
                                                required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-medium mb-2">Mot de passe</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-lock"></i>
                                            </span>
                                            <input type="password"
                                                class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                                                name="password" placeholder="Créez un mot de passe" required>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password Confirmation -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-medium mb-2">Confirmer le mot de passe</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-shield-lock"></i>
                                            </span>
                                            <input type="password" class="form-control border-start-0 ps-0"
                                                name="password_confirmation" placeholder="Confirmez le mot de passe"
                                                required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <!-- Profile Picture -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-medium mb-2">Photo de profil</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-image"></i>
                                            </span>
                                            <input type="file"
                                                class="form-control border-start-0 ps-0 @error('profile_pic') is-invalid @enderror"
                                                name="profile_pic" accept="image/*">
                                        </div>
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Optionnel - Format JPG, PNG (max 2MB)
                                        </div>
                                        @error('profile_pic')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Bio -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-medium mb-2">Biographie</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-journal-text"></i>
                                            </span>
                                            <textarea class="form-control border-start-0 ps-0 @error('bio') is-invalid @enderror" name="bio" rows="4"
                                                style="resize: none;" placeholder="Parlez-nous un peu de vous...">{{ old('bio') }}</textarea>
                                        </div>
                                        <div class="form-text">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Optionnel - Présentez-vous en quelques mots
                                        </div>
                                        @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-person-plus me-2"></i>Créer mon compte
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <p class="text-secondary mb-0">
                                Déjà inscrit ?
                                <a href="{{ route('login') }}" class="text-decoration-none fw-medium login-link">
                                    Connectez-vous <i class="bi bi-arrow-right"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .register-form {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-control {
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all var(--transition-speed);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(26, 86, 219, 0.1);
        }

        .input-group-text {
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            transition: all var(--transition-speed);
        }

        .form-text {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all var(--transition-speed);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .login-link {
            color: var(--primary-color);
            transition: all var(--transition-speed);
        }

        .login-link:hover {
            color: var(--primary-hover);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
@endsection
