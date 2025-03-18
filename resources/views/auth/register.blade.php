@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-smooth border-0 p-4">
                    <div class="text-center mb-4">
                        <h3 class="font-medium mb-1">Créer un compte</h3>
                        <p class="text-muted text-sm">Rejoignez notre communauté</p>
                    </div>

                    <div class="card-body px-0 pb-0">
                        <form action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="username" class="form-label text-sm font-medium">Nom d'utilisateur</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-person text-muted"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control border-start-0 ps-0 @error('username') is-invalid @enderror"
                                        id="username" name="username" value="{{ old('username') }}"
                                        placeholder="Entrez votre pseudo" required>
                                </div>
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label text-sm font-medium">Adresse email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input type="email"
                                        class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Entrez votre adresse email" required>
                                </div>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label text-sm font-medium">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input type="password"
                                        class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Entrez votre mot de passe" required>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label text-sm font-medium">Confirmer le mot
                                    de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-shield-lock text-muted"></i>
                                    </span>
                                    <input type="password" class="form-control border-start-0 ps-0"
                                        id="password_confirmation" name="password_confirmation"
                                        placeholder="Confirmez votre mot de passe" required>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="bio" class="form-label text-sm font-medium">Biographie</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-journal-text text-muted"></i>
                                    </span>
                                    <textarea class="form-control border-start-0 ps-0 @error('bio') is-invalid @enderror" id="bio" name="bio"
                                        rows="3" style="resize: none;" placeholder="Parlez-nous un peu de vous...">{{ old('bio') }}</textarea>
                                </div>
                                @error('bio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="profile_pic" class="form-label text-sm font-medium">Photo de profil</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-image text-muted"></i>
                                    </span>
                                    <input type="file"
                                        class="form-control border-start-0 ps-0 @error('profile_pic') is-invalid @enderror"
                                        id="profile_pic" name="profile_pic" accept="image/*">
                                </div>
                                @error('profile_pic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-primary rounded-pill py-2 hover-lift">
                                    <i class="bi bi-person-plus me-2"></i>Créer mon compte
                                </button>
                            </div>
                        </form>

                        <div class="mt-4 text-center">
                            <p class="text-muted mb-0">
                                Déjà inscrit ?
                                <a href="{{ route('login') }}" class="text-primary font-medium">
                                    Connectez-vous <i class="bi bi-arrow-right"></i>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
