@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Call-to-action for non-authenticated users -->
        @guest
            <div class="welcome-banner p-4 mb-5 rounded-4 bg-white shadow-sm border" role="alert">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h2 class="fw-bold mb-2" style="color: var(--primary-color)">Bienvenue sur notre réseau social !</h2>
                        <p class="lead mb-0 text-secondary">Rejoignez notre communauté pour partager vos moments et interagir
                            avec d'autres membres.</p>
                    </div>
                    <div class="col-lg-4 mt-3 mt-lg-0 text-lg-end">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2 mb-2 mb-lg-0">
                            <i class="bi bi-person-plus me-2"></i>S'inscrire
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </a>
                    </div>
                </div>
            </div>
        @endguest

        <!-- Posts Grid -->
        <div class="row g-4">
            @forelse ($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <!-- Author Section -->
                            <div class="d-flex align-items-center mb-3">
                                <a href="{{ Auth::check() && Auth::id() === $post->author_id ? route('profile') : route('profile.public', $post->author->username) }}"
                                    class="author-link">
                                    <img src="{{ $post->author->profile_pic ? asset('storage/' . $post->author->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}"
                                        class="rounded-circle border shadow-sm" alt="Photo de profil"
                                        style="width: 48px; height: 48px; object-fit: cover;">
                                </a>
                                <div class="ms-3">
                                    <h6 class="fw-bold mb-0" style="color: var(--primary-color)">{{ $post->author->name }}
                                    </h6>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $post->created_at->format('d/m/Y \\à H:i') }}
                                    </small>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="post-content">
                                @if ($post->post_resource)
                                    <div class="post-image mb-3 rounded-4 overflow-hidden shadow-sm">
                                        <div class="ratio ratio-1x1">
                                            <img src="{{ asset('storage/' . $post->post_resource) }}"
                                                class="img-fluid object-fit-cover w-100 h-100" alt="Image du post">
                                        </div>
                                    </div>
                                @endif
                                <p class="card-text">{{ Str::limit($post->description, 100) }}</p>
                            </div>

                            <!-- View Post Link -->
                            <div class="mt-3 text-end">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye me-1"></i>Voir plus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 my-5">
                        <i class="bi bi-camera text-muted" style="font-size: 3rem;"></i>
                        <h3 class="mt-3 fw-bold" style="color: var(--primary-color)">Aucun post à afficher</h3>
                        <p class="text-secondary mb-4">Soyez le premier à partager quelque chose !</p>
                        @auth
                            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Créer un post
                            </a>
                        @endauth
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            {{ $posts->links() }}
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

        .card {
            border: 1px solid var(--border-color);
            transition: all var(--transition-speed);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .post-image img {
            transition: transform var(--transition-speed);
        }

        .post-image:hover img {
            transform: scale(1.05);
        }

        /* Custom Pagination Styling */
        .pagination {
            gap: 0.5rem;
        }

        .page-item .page-link {
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            color: var(--primary-color);
            padding: 0.75rem 1rem;
            transition: all var(--transition-speed);
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .page-item .page-link:hover {
            background-color: var(--background-light);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
    </style>
@endsection
