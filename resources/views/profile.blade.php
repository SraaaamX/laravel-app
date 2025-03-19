@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Profile Card -->
                <div class="card shadow-lg rounded-4 border-0 overflow-hidden">
                    <!-- Profile Header -->
                    <div class="position-relative">
                        <div class="bg-gradient text-white text-center py-5">
                            <div class="position-absolute w-100" style="bottom: -50px">
                                @if (auth()->user()->profile_pic)
                                    <img src="{{ asset('storage/' . auth()->user()->profile_pic) }}" alt="Photo de profil"
                                        class="rounded-circle border-4 border-white shadow-lg profile-picture"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                                        alt="Photo de profil par défaut"
                                        class="rounded-circle border-4 border-white shadow-lg profile-picture"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Profile Form -->
                    <div class="card-body pt-5 mt-4 pb-4">
                        @if (session('profile_error'))
                            <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
                                {{ session('profile_error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <!-- Photo de profil -->
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
                                        @error('profile_pic')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Username -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-medium mb-2">Nom d'utilisateur</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-person"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control border-start-0 ps-0 @error('username') is-invalid @enderror"
                                                name="username" value="{{ old('username', auth()->user()->username) }}"
                                                required>
                                        </div>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group mb-4">
                                        <label class="form-label fw-medium mb-2">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-envelope"></i>
                                            </span>
                                            <input type="email"
                                                class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                        </div>
                                        @error('email')
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
                                            <textarea class="form-control border-start-0 ps-0 @error('bio') is-invalid @enderror" name="bio" rows="3"
                                                style="resize: none;">{{ old('bio', auth()->user()->bio) }}</textarea>
                                        </div>
                                        @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-grid gap-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check2-circle me-2"></i>Mettre à jour le profil
                                        </button>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#changePasswordModal">
                                            <i class="bi bi-key me-2"></i>Modifier le mot de passe
                                        </button>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteConfirmModal">
                                            <i class="bi bi-trash me-2"></i>Supprimer le compte
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Publications -->
                <div class="card shadow-lg rounded-4 border-0 mt-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0" style="color: var(--primary-color)">
                                <i class="bi bi-grid-3x3-gap me-2"></i>Mes Publications
                            </h4>
                            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Nouvelle publication
                            </a>
                        </div>

                        @if (count(auth()->user()->posts) > 0)
                            <div class="row g-4">
                                @foreach (auth()->user()->posts as $post)
                                    <div class="col-md-6">
                                        <div class="card h-100 border post-card">
                                            @if ($post->post_resource)
                                                <a href="{{ route('posts.show', $post->id) }}" class="post-image-link">
                                                    <div class="ratio ratio-1x1">
                                                        <img src="{{ asset('storage/' . $post->post_resource) }}"
                                                            class="card-img-top object-fit-cover" alt="Post media">
                                                    </div>
                                                </a>
                                            @endif
                                            <div class="card-body">
                                                <p class="card-text text-secondary">
                                                    {{ Str::limit($post->description, 100) }}</p>
                                                <div class="d-flex justify-content-between align-items-center mt-3">
                                                    <div class="btn-group">
                                                        <a href="{{ route('posts.edit', $post->id) }}"
                                                            class="btn btn-sm btn-outline-primary">
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
                                                    <small class="text-muted">
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
                                <h5 class="mt-3 fw-bold" style="color: var(--primary-color)">Aucune publication</h5>
                                <p class="text-secondary mb-4">Commencez à partager vos moments avec la communauté !</p>
                                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-2"></i>Créer ma première publication
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">Modifier le mot de passe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('profile.updatePassword') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Mot de passe actuel</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password"
                                    class="form-control border-start-0 ps-0 @error('current_password') is-invalid @enderror"
                                    name="current_password" required>
                            </div>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Nouveau mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-key"></i>
                                </span>
                                <input type="password"
                                    class="form-control border-start-0 ps-0 @error('new_password') is-invalid @enderror"
                                    name="new_password" required>
                            </div>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Le mot de passe doit contenir au moins 8 caractères
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Confirmer le nouveau mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-key-fill"></i>
                                </span>
                                <input type="password" class="form-control border-start-0 ps-0"
                                    name="new_password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check2 me-2"></i>Modifier le mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                        Confirmation de suppression
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-secondary mb-0">Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est
                        irréversible et supprimera toutes vos données.</p>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('profile.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Confirmer la suppression
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
        }

        .profile-picture {
            transition: transform var(--transition-speed);
        }

        .profile-picture:hover {
            transform: scale(1.05);
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: all var(--transition-speed);
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .post-card {
            transition: all var(--transition-speed);
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .post-image-link {
            overflow: hidden;
            display: block;
        }

        .post-image-link img {
            transition: transform var(--transition-speed);
        }

        .post-image-link:hover img {
            transform: scale(1.05);
        }

        .modal-content {
            border: none;
        }

        .modal-header,
        .modal-footer {
            padding: 1.25rem 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .btn-group .btn {
            border-radius: 0.5rem !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (
                (session('error') && !session('profile_error')) ||
                    $errors->has('current_password') ||
                    $errors->has('new_password') ||
                    $errors->has('new_password_confirmation'))
                var modal = new bootstrap.Modal(document.getElementById('changePasswordModal'));
                modal.show();
            @endif

            @if (session('password_updated'))
                var modal = bootstrap.Modal.getInstance(document.getElementById('changePasswordModal'));
                if (modal) {
                    modal.hide();
                }
            @endif
        });
    </script>
@endpush
