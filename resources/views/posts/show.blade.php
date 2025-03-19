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
