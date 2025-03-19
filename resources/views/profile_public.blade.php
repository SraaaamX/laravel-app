@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-smooth border-0">
                    <div class="bg-primary text-white text-center py-5 position-relative">
                        <div class="position-absolute w-100" style="bottom: -75px">
                            @if ($user->profile_pic)
                                <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="Photo de profil"
                                    class="rounded-circle border border-4 border-white shadow-sm"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                                    alt="Photo de profil par défaut"
                                    class="rounded-circle border border-4 border-white shadow-sm"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                        </div>
                    </div>

                    <div class="card-body pt-5 mt-4">
                        <div class="text-center mb-4">
                            <h2 class="mb-1">{{ $user->username }}</h2>
                            @if ($user->bio)
                                <p class="text-muted mb-0">{{ $user->bio }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card shadow-smooth border-0 mt-4">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Publications</h4>

                        @if (count($posts) > 0)
                            <div class="row">
                                @foreach ($posts as $post)
                                    <div class="col-md-6 mb-4">
                                        <div class="card">
                                            @if ($post->post_resource)
                                                <div class="ratio ratio-1x1">
                                                    @if (Str::endsWith($post->post_resource, ['.mp4']))
                                                        <video class="card-img-top object-fit-cover" controls>
                                                            <source src="{{ asset('storage/' . $post->post_resource) }}"
                                                                type="video/mp4">
                                                            Votre navigateur ne supporte pas la lecture de vidéos.
                                                        </video>
                                                    @else
                                                        <img src="{{ asset('storage/' . $post->post_resource) }}"
                                                            class="card-img-top object-fit-cover" alt="Image du post">
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <p class="card-text">{{ $post->description }}</p>
                                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                            </div>
                                            <a href="{{ route('posts.show', $post->id) }}" class="stretched-link"></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                <p class="mt-3 text-muted">Aucune publication à afficher.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
