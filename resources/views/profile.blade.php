@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-smooth border-0">
                    <div class="bg-primary text-white text-center py-5 position-relative">
                        <div class="position-absolute w-100" style="bottom: -75px">
                            @if (auth()->user()->profile_pic)
                                <img src="{{ asset('storage/' . auth()->user()->profile_pic) }}" alt="Profile Picture"
                                    class="rounded-circle border border-4 border-white shadow-sm"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                                    alt="Default Profile Picture"
                                    class="rounded-circle border border-4 border-white shadow-sm"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                        </div>
                    </div>

                    <div class="card-body pt-5 mt-4">
                        @if (session('profile_error'))
                            <div class="alert alert-danger mb-4">
                                {{ session('profile_error') }}
                            </div>
                        @endif
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="mb-4">
                                        <label for="profile_pic" class="form-label text-sm font-medium">Photo de
                                            profil</label>
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

                                    <div class="mb-4">
                                        <label for="username" class="form-label text-sm font-medium">Nom
                                            d'utilisateur</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-person text-muted"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control border-start-0 ps-0 @error('username') is-invalid @enderror"
                                                id="username" name="username"
                                                value="{{ old('username', auth()->user()->username) }}" required>
                                        </div>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="form-label text-sm font-medium">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-envelope text-muted"></i>
                                            </span>
                                            <input type="email"
                                                class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                                id="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}" required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="bio" class="form-label text-sm font-medium">Biographie</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-journal-text text-muted"></i>
                                            </span>
                                            <textarea class="form-control border-start-0 ps-0 @error('bio') is-invalid @enderror" id="bio" name="bio"
                                                rows="3" placeholder="Parlez-nous un peu de vous..." style="resize: none;">{{ old('bio', auth()->user()->bio) }}</textarea>
                                        </div>
                                        @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-grid gap-3">
                                        <button type="submit" class="btn btn-primary rounded-pill py-2 hover-lift">
                                            <i class="bi bi-check2-circle me-2"></i>Mettre à jour le profil
                                        </button>
                                        <button type="button" class="btn btn-warning rounded-pill py-2"
                                            data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                            <i class="bi bi-key me-2"></i>Modifier le mot de passe
                                        </button>
                                        <button type="button" class="btn btn-danger rounded-pill py-2"
                                            data-bs-toggle="modal" data-bs-target="#deleteConfirmModal">
                                            <i class="bi bi-trash me-2"></i>Supprimer le compte
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card shadow-smooth border-0 mt-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="card-title mb-0">Mes Publications</h4>
                            <a href="{{ route('posts.create') }}" class="btn btn-primary rounded-pill">
                                <i class="bi bi-plus-circle me-2"></i>Nouvelle publication
                            </a>
                        </div>

                        @if (count(auth()->user()->posts) > 0)
                            <div class="row">
                                @foreach (auth()->user()->posts as $post)
                                    <div class="col-md-6 mb-4">
                                        <div class="card" style="max-width: 350px;">
                                            @if ($post->post_resource)
                                                <img src="{{ asset('storage/' . $post->post_resource) }}"
                                                    class="card-img-top" alt="Post media"
                                                    style="max-height: 150px; object-fit: cover;">
                                            @endif
                                            <div class="card-body">
                                                <p class="card-text" style="font-size: 0.8rem;">{{ $post->description }}
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="btn-group" style="font-size: 0.8rem;">
                                                        <a href="{{ route('posts.edit', $post->id) }}"
                                                            class="btn btn-sm btn-outline-secondary">
                                                            <i class="bi bi-pencil me-1"></i>Modifier
                                                        </a>
                                                        <form action="{{ route('posts.destroy', $post->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-outline-danger ms-2">
                                                                <i class="bi bi-trash me-1"></i>Supprimer
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <small class="text-muted" style="font-size: 0.8rem;">
                                                        <i class="bi bi-heart me-1"></i>{{ $post->likesNumber }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                <p class="mt-3 text-muted">Vous n'avez pas encore de publications.</p>
                                <a href="{{ route('posts.create') }}" class="btn btn-primary rounded-pill mt-2">
                                    Créer ma première publication
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de modification du mot de passe -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true" @if ($errors->any() || session('error')) data-bs-backdrop="static" @endif>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Modifier le mot de passe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('profile.updatePassword') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Mot de passe actuel</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                id="new_password" name="new_password" required>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Le mot de passe doit contenir au moins 8 caractères</div>
                        </div>
                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirmer le nouveau mot de
                                passe</label>
                            <input type="password"
                                class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                id="new_password_confirmation" name="new_password_confirmation" required>
                            @error('new_password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-warning">Modifier le mot de passe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('profile.delete') }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show modal only for password-related errors, not profile errors
            @if (
                (session('error') && !session('profile_error')) ||
                    $errors->has('current_password') ||
                    $errors->has('new_password') ||
                    $errors->has('new_password_confirmation'))
                var modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                modal.show();
            @endif

            @if (session('password_updated'))
                // Ferme le modal si le mot de passe a été mis à jour avec succès
                var modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                if (modal) {
                    modal.hide();
                }
            @endif
        });
    </script>
@endpush
