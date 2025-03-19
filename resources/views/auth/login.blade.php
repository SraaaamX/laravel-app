@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg rounded-4 border-0 overflow-hidden fade-in">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="mb-4">
                                <i class="bi bi-people-fill" style="font-size: 3rem; color: var(--primary-color);"></i>
                            </div>
                            <h3 class="fw-bold mb-2" style="color: var(--primary-color);">Connexion</h3>
                            <p class="text-secondary mb-0">Bienvenue sur notre réseau social</p>
                        </div>

                        <form method="POST" action="{{ route('login.submit') }}" class="login-form">
                            @csrf
                            @method('POST')

                            <div class="form-group mb-4">
                                <label class="form-label fw-medium mb-2">Adresse email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email"
                                        class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" placeholder="Entrez votre adresse email"
                                        required autofocus>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label fw-medium mb-2">Nom d'utilisateur</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control border-start-0 ps-0 @error('username') is-invalid @enderror"
                                        name="username" value="{{ old('username') }}"
                                        placeholder="Entrez votre nom d'utilisateur" required>
                                </div>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label fw-medium mb-2">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password"
                                        class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                                        name="password" placeholder="Entrez votre mot de passe" required>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <p class="text-secondary mb-0">
                                Pas encore de compte ?
                                <a href="{{ route('register') }}" class="text-decoration-none fw-medium register-link">
                                    Inscrivez-vous <i class="bi bi-arrow-right"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .login-form {
            max-width: 400px;
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

        .btn {
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all var(--transition-speed);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .register-link {
            color: var(--primary-color);
            transition: all var(--transition-speed);
        }

        .register-link:hover {
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
