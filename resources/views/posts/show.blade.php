@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="row g-0">
                        <!-- Media Section (Left) -->
                        <div class="col-lg-8">
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
                            <div class="card-body">
                                <!-- Author Info -->
                                <div class="d-flex align-items-center mb-4">
                                    <a href="{{ Auth::check() && Auth::id() === $post->author_id ? route('profile') : route('profile.public', $post->author->username) }}"
                                        class="d-block">
                                        <img src="{{ $post->author->profile_pic ? asset('storage/' . $post->author->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}"
                                            class="rounded-circle me-3" alt="Photo de profil"
                                            style="width: 48px; height: 48px; object-fit: cover;">
                                    </a>
                                    <div>
                                        <h5 class="mb-0">{{ $post->author->name }}</h5>
                                        <small class="text-muted">{{ $post->created_at->format('d/m/Y \\à H:i') }}</small>
                                    </div>
                                </div>

                                <!-- Post Description -->
                                <p class="card-text">{{ $post->description }}</p>

                                <!-- Actions for post owner -->
                                @if (Auth::check() && Auth::id() === $post->author_id)
                                    <div class="mt-4 d-flex gap-2">
                                        <a href="{{ route('posts.edit', $post->id) }}"
                                            class="btn btn-outline-primary btn-sm">
                                            Modifier
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="mt-4">
                    <h4 class="mb-3">Commentaires</h4>

                    <!-- Comment Form -->
                    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="form-group">
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="3"
                                placeholder="Ajouter un commentaire..."></textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Commenter</button>
                    </form>

                    @foreach ($comments as $comment)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="d-flex align-items-center">
                                        <a
                                            href="{{ Auth::id() === $comment->user_id ? route('profile') : route('profile.public', $comment->user->username) }}">
                                            <img src="{{ $comment->user->profile_pic ? asset('storage/' . $comment->user->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
                                                class="rounded-circle me-2" alt="Photo de profil"
                                                style="width: 32px; height: 32px; object-fit: cover;">
                                        </a>
                                        <div>
                                            <h6 class="mb-0">{{ $comment->user->name }}</h6>
                                            <small
                                                class="text-muted">{{ $comment->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </div>
                                    @if (Auth::id() === $comment->user_id)
                                        <div class="dropdown">
                                            <button class="btn btn-link dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown">
                                                <i class="bi bi-three-dots"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#editComment{{ $comment->id }}">
                                                        Modifier
                                                    </button>
                                                </li>
                                                <li>
                                                    <form action="{{ route('comments.destroy', $comment->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"
                                                            onclick="return confirm('Voulez-vous vraiment supprimer ce commentaire ?')">
                                                            Supprimer
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="modal fade" id="editComment{{ $comment->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Modifier le commentaire</h5>
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
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit"
                                                                class="btn btn-primary">Sauvegarder</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <p class="card-text">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $comments->links() }}
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                        Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
