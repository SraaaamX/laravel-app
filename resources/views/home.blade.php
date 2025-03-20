@extends('layouts.app')

@section('content')
    <div class="page-container">
        <!-- Call-to-action for non-authenticated users -->
        @guest
            <div class="welcome-banner">
                <h2>Bienvenue sur notre réseau social !</h2>
                <p>Rejoignez notre communauté pour partager vos moments et interagir avec d'autres membres.</p>
                <div class="welcome-actions">
                    <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
                    <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
                </div>
            </div>
        @endguest

        <!-- Left Column -->
        <div class="content-columns">
            <div class="left-column">
                @auth
                    <div class="create-post-box">
                        <a href="{{ route('posts.create') }}" class="create-post-link">
                            Quoi de neuf ?
                        </a>
                    </div>
                @endauth

                <!-- Posts List -->
                <div class="posts-feed">
                    @forelse ($posts as $post)
                        <div class="post-card">
                            <div class="post-header">
                                <div class="post-author">
                                    <a
                                        href="{{ Auth::check() && Auth::id() === $post->author_id ? route('profile') : route('profile.public', $post->author->username) }}">
                                        <img src="{{ $post->author->profile_pic ? asset('storage/' . $post->author->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}"
                                            alt="Photo de profil">
                                    </a>
                                    <div class="post-info">
                                        <a href="{{ Auth::check() && Auth::id() === $post->author_id ? route('profile') : route('profile.public', $post->author->username) }}"
                                            class="author-name">{{ $post->author->name }}</a>
                                        <span class="post-time">{{ $post->created_at->format('d/m/Y \\à H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="post-content">
                                @if ($post->post_resource)
                                    <div class="post-image">
                                        <img src="{{ asset('storage/' . $post->post_resource) }}" alt="Image du post">
                                    </div>
                                @endif
                                <p>{{ Str::limit($post->description, 100) }}</p>
                            </div>

                            <div class="post-actions">
                                <a href="{{ route('posts.show', $post->id) }}" class="post-action-link">Voir plus</a>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-state-content">
                                <p>Aucun post à afficher</p>
                                <p>Soyez le premier à partager quelque chose !</p>
                                @auth
                                    <a href="{{ route('posts.create') }}" class="btn btn-primary">Créer un post</a>
                                @endauth
                            </div>
                        </div>
                    @endforelse

                    <!-- Pagination -->
                    <div class="pagination-container">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <div class="right-box">
                    <div class="box-header">
                        <h3>À propos</h3>
                    </div>
                    <div class="box-content">
                        <p>Bienvenue sur notre réseau social inspiré de l'ancien Facebook !</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .page-container {
            max-width: 850px;
            margin: 20px auto;
            padding: 0 15px;
        }

        .content-columns {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .left-column {
            flex: 1;
            max-width: 550px;
        }

        .right-column {
            width: 240px;
            flex-shrink: 0;
        }

        .right-box {
            background: var(--white);
            border: 1px solid var(--facebook-border);
            margin-bottom: 20px;
        }

        .box-header {
            background: var(--facebook-light-blue);
            padding: 8px 10px;
            border-bottom: 1px solid var(--facebook-border);
        }

        .box-header h3 {
            margin: 0;
            font-size: 11px;
            font-weight: bold;
            color: var(--facebook-text);
        }

        .box-content {
            padding: 10px;
            font-size: 11px;
            color: var(--facebook-text);
        }

        .welcome-banner {
            background: var(--facebook-light-blue);
            border: 1px solid var(--facebook-border);
            padding: 10px;
            margin-bottom: 20px;
        }

        .welcome-banner h2 {
            color: var(--facebook-text);
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .welcome-banner p {
            color: var(--facebook-text);
            font-size: 11px;
            margin-bottom: 8px;
        }

        .welcome-actions {
            margin-top: 8px;
        }

        .create-post-box {
            background: var(--white);
            border: 1px solid var(--facebook-border);
            margin-bottom: 10px;
            padding: 8px;
        }

        .create-post-link {
            color: #666;
            text-decoration: none;
            display: block;
            font-size: 11px;
            padding: 3px;
        }

        .post-card {
            background: var(--white);
            border: 1px solid var(--facebook-border);
            margin-bottom: 10px;
        }

        .post-header {
            padding: 8px;
            border-bottom: 1px solid var(--facebook-border);
            background: var(--facebook-light-blue);
        }

        .post-author {
            display: flex;
            align-items: center;
        }

        .post-author img {
            width: 32px;
            height: 32px;
            border-radius: 2px;
            margin-right: 8px;
        }

        .post-info {
            display: flex;
            flex-direction: column;
        }

        .author-name {
            color: var(--facebook-link);
            font-weight: bold;
            text-decoration: none;
            font-size: 11px;
        }

        .post-time {
            color: #666;
            font-size: 10px;
        }

        .post-content {
            padding: 8px;
        }

        .post-content p {
            margin: 0;
            font-size: 11px;
            color: var(--facebook-text);
        }

        .post-image {
            margin: -8px -8px 8px -8px;
            max-height: 350px;
            overflow: hidden;
        }

        .post-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .post-actions {
            padding: 4px 8px;
            border-top: 1px solid var(--facebook-border);
            background: var(--facebook-light-blue);
        }

        .post-action-link {
            color: var(--facebook-link);
            text-decoration: none;
            font-size: 11px;
        }

        .post-action-link:hover {
            text-decoration: underline;
        }

        .empty-state {
            text-align: center;
            padding: 20px 0;
        }

        .empty-state-content {
            color: #666;
            font-size: 11px;
        }

        .empty-state-content p {
            margin: 3px 0;
        }

        .pagination-container {
            padding: 8px;
            text-align: center;
            border-top: 1px solid var(--facebook-border);
        }

        /* Classic Facebook Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 3px;
            margin: 0;
        }

        .page-link {
            padding: 3px 6px;
            color: var(--facebook-link);
            background: var(--white);
            border: 1px solid var(--facebook-border);
            font-size: 11px;
            text-decoration: none;
        }

        .page-item.active .page-link {
            background: var(--facebook-light-blue);
            border-color: var(--facebook-border);
            color: var(--facebook-text);
        }

        .page-link:hover {
            background: var(--facebook-light-blue);
            text-decoration: none;
        }

        .btn {
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 0;
        }

        .btn-primary {
            background: #5b74a8;
            background-image: linear-gradient(#637bad, #5872a7);
            border: 1px solid;
            border-color: #29447e #29447e #1a356e;
            color: white;
            font-weight: bold;
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .content-columns {
                flex-direction: column;
            }

            .right-column {
                width: 100%;
            }

            .left-column {
                max-width: 100%;
            }
        }
    </style>
@endsection
