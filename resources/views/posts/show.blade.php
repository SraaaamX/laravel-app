@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Post Card -->
                <div class="card shadow-lg rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <!-- Media Section (Left) -->
                        <div class="col-lg-8 bg-light">
                            @if ($post->post_resource)
                                @if (Str::endsWith($post->post_resource, ['.mp4']))
                                    <div class="ratio ratio-1x1">
                                        <video class="w-100 h-100 object-fit-cover" controls>
                                            <source src="{{ asset('storage/' . $post->post_resource) }}" type="video/mp4">
                                            Votre navigateur ne supporte pas la lecture de vidéos.
                                        </video>
                                    </div>
                                @else
                                    <div class="ratio ratio-1x1">
                                        <img src="{{ asset('storage/' . $post->post_resource) }}"
                                            class="w-100 h-100 object-fit-cover" alt="Image du post">
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Info Section (Right) -->
                        <div class="col-lg-4">
                            <div class="card-body p-4">
                                <!-- Author Info -->
                                <div class="d-flex align-items-center mb-4">
                                    <a href="{{ Auth::check() && Auth::id() === $post->author_id ? route('profile') : route('profile.public', $post->author->username) }}"
                                        class="author-link me-3">
                                        <img src="{{ $post->author->profile_pic ? asset('storage/' . $post->author->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}"
                                            class="rounded-circle border shadow-sm" alt="Photo de profil"
                                            style="width: 48px; height: 48px; object-fit: cover;">
                                    </a>
                                    <div>
                                        <h5 class="fw-bold mb-0" style="color: var(--primary-color)">
                                            {{ $post->author->name }}</h5>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $post->created_at->format('d/m/Y \\à H:i') }}
                                        </small>
                                    </div>
                                </div>

                                <!-- Post Description -->
                                <p class="card-text text-secondary">{{ $post->description }}</p>

                                <!-- Actions for post owner -->
                                @if (Auth::check() && Auth::id() === $post->author_id)
                                    <div class="mt-4 d-flex gap-2">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-pencil me-2"></i>Modifier
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?')">
                                                <i class="bi bi-trash me-2"></i>Supprimer
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="mt-5">
                    <h4 class="fw-bold mb-4" style="color: var(--primary-color)">
                        <i class="bi bi-chat-dots me-2"></i>Commentaires
                    </h4>

                    <!-- Comment Form -->
                    <div class="card shadow-sm rounded-4 mb-4">
                        <div class="card-body p-4">
                            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3"
                                        placeholder="Ajouter un commentaire..."></textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send me-2"></i>Commenter
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Comments List -->
                    @foreach ($comments as $comment)
                        <div class="card shadow-sm rounded-4 mb-3 comment-card">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ Auth::id() === $comment->user_id ? route('profile') : route('profile.public', $comment->user->username) }}"
                                            class="author-link me-3">
                                            <img src="{{ $comment->user->profile_pic ? asset('storage/' . $comment->user->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
                                                class="rounded-circle border shadow-sm" alt="Photo de profil"
                                                style="width: 40px; height: 40px; object-fit: cover;">
                                        </a>
                                        <div>
                                            <h6 class="fw-bold mb-0" style="color: var(--primary-color)">
                                                {{ $comment->user->name }}</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $comment->created_at->format('d/m/Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                    @if (Auth::id() === $comment->user_id)
                                        <div class="dropdown">
                                            <button class="btn btn-link text-muted p-0" type="button"
                                                data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border">
                                                <li>
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editComment{{ $comment->id }}">
                                                        <i class="bi bi-pencil me-2"></i>Modifier
                                                    </button>
                                                </li>
                                                <li>
                                                    <form action="{{ route('comments.destroy', $comment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer ce commentaire ?')">
                                                            <i class="bi bi-trash me-2"></i>Supprimer
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>

                                        <!-- Edit Comment Modal -->
                                        <div class="modal fade" id="editComment{{ $comment->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content rounded-4">
                                                    <div class="modal-header border-bottom">
                                                        <h5 class="modal-title fw-bold">Modifier le commentaire</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('comments.update', $comment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <textarea name="content" class="form-control" rows="3">{{ $comment->content }}</textarea>
                                                        </div>
                                                        <div class="modal-footer border-top">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="bi bi-check2 me-2"></i>Sauvegarder
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <p class="card-text text-secondary mb-0">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $comments->links() }}
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-light">
                        <i class="bi bi-arrow-left me-2"></i>Retour
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .author-link {
            transition: transform var(--transition-speed);
            display: inline-block;
        }

        .author-link:hover {
            transform: scale(1.1);
        }

        .comment-card {
            transition: all var(--transition-speed);
        }

        .comment-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md) !important;
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

        .btn {
            display: inline-flex;
            align-items: center;
            font-weight: 500;
            transition: all var(--transition-speed);
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .dropdown-menu {
            border-radius: 0.75rem;
            padding: 0.5rem;
        }

        .dropdown-item {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
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
    </style>
@endsection
