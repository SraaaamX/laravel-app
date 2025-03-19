@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <!-- Call-to-action for non-authenticated users -->
        @guest
            <div class="alert alert-primary mb-4" role="alert">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="alert-heading mb-1">Bienvenue sur notre réseau social !</h4>
                        <p class="mb-0">Rejoignez notre communauté pour partager vos moments et interagir avec d'autres
                            membres.</p>
                    </div>
                    <div>
                        <a href="{{ route('register') }}" class="btn btn-primary me-2">S'inscrire</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">Se connecter</a>
                    </div>
                </div>
            </div>
        @endguest

        <!-- Posts Column -->
        <div class="row">
            @forelse ($posts as $post)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm" style="height: 100%">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <a href="{{ Auth::check() && Auth::id() === $post->author_id ? route('profile') : route('profile.public', $post->author->username) }}"
                                    style="z-index: 2; position: relative;">
                                    <img src="{{ $post->author->profile_pic ? asset('storage/' . $post->author->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}"
                                        class="rounded-circle me-3" alt="Photo de profil"
                                        style="width: 48px; height: 48px; object-fit: cover;">
                                </a>
                                <div>
                                    <h6 class="card-title">{{ $post->author->name }}</h6>
                                    <small class="text-muted">{{ $post->created_at->format('d/m/Y \\à H:i') }}</small>
                                </div>
                            </div>
                            <div class="mt-3">
                                @if ($post->post_resource)
                                    <div class="ratio ratio-1x1">
                                        <img src="{{ asset('storage/' . $post->post_resource) }}"
                                            class="img-fluid object-fit-cover" alt="Image du post"
                                            style="object-position: center;">
                                    </div>
                                @endif
                                <p class="card-text mt-2">{{ Str::limit($post->description, 20) }}</p>
                            </div>
                            <a href="{{ route('posts.show', $post->id) }}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h3>Aucun post à afficher pour le moment</h3>
                    <p class="text-muted">Soyez le premier à partager quelque chose !</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
