@extends('layouts.app')

@section('content')
    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-picture-container">
                @if ($user->profile_pic)
                    <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="Photo de profil" class="profile-picture">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random"
                        alt="Photo de profil par défaut" class="profile-picture">
                @endif
            </div>
            <h1 class="profile-name">{{ $user->username }}</h1>
            @if ($user->bio)
                <p class="profile-bio">{{ $user->bio }}</p>
            @endif
        </div>

        <!-- Content Container -->
        <div class="posts-section">
            <div class="posts-header">
                <h3>Publications</h3>
            </div>

            <div class="posts-grid">
                @if (count($posts) > 0)
                    @foreach ($posts as $post)
                        <div class="post-card">
                            @if ($post->post_resource)
                                <div class="post-image">
                                    @if (Str::endsWith($post->post_resource, ['.mp4']))
                                        <video controls>
                                            <source src="{{ asset('storage/' . $post->post_resource) }}" type="video/mp4">
                                            Votre navigateur ne supporte pas la lecture de vidéos.
                                        </video>
                                    @else
                                        <img src="{{ asset('storage/' . $post->post_resource) }}" alt="Image du post">
                                    @endif
                                </div>
                            @endif
                            <div class="post-content">
                                <p>{{ Str::limit($post->description, 100) }}</p>
                                <div class="post-meta">
                                    <span class="post-time">{{ $post->created_at->diffForHumans() }}</span>
                                    <a href="{{ route('posts.show', $post->id) }}" class="action-link">Voir plus</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-posts">
                        <p>Aucune publication à afficher.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .profile-container {
            max-width: 850px;
            margin: 20px auto;
            padding: 0 15px;
        }

        .profile-header {
            background: var(--facebook-light-blue);
            border: 1px solid var(--facebook-border);
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }

        .profile-picture-container {
            margin-bottom: 8px;
        }

        .profile-picture {
            width: 160px;
            height: 160px;
            border: 1px solid var(--facebook-border);
            padding: 3px;
            background: white;
        }

        .profile-name {
            color: var(--facebook-link);
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 5px 0;
        }

        .profile-bio {
            color: var(--facebook-text);
            font-size: 11px;
            margin: 0;
        }

        .posts-section {
            background: white;
            border: 1px solid var(--facebook-border);
        }

        .posts-header {
            background: var(--facebook-light-blue);
            padding: 6px 8px;
            border-bottom: 1px solid var(--facebook-border);
        }

        .posts-header h3 {
            margin: 0;
            font-size: 11px;
            font-weight: bold;
            color: var(--facebook-text);
        }

        .posts-grid {
            padding: 8px;
        }

        .post-card {
            border: 1px solid var(--facebook-border);
            margin-bottom: 8px;
            background: white;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .post-image {
            border-bottom: 1px solid var(--facebook-border);
            max-height: 250px;
            overflow: hidden;
        }

        .post-image img,
        .post-image video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .post-content {
            padding: 8px;
        }

        .post-content p {
            margin: 0 0 8px 0;
            font-size: 11px;
            color: var(--facebook-text);
        }

        .post-meta {
            border-top: 1px solid var(--facebook-border);
            padding-top: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
        }

        .post-time {
            color: #666;
        }

        .action-link {
            color: var(--facebook-link);
            text-decoration: none;
            font-size: 11px;
        }

        .action-link:hover {
            text-decoration: underline;
        }

        .empty-posts {
            text-align: center;
            padding: 20px;
            color: #666;
            font-size: 11px;
        }

        .empty-posts p {
            margin: 3px 0;
        }

        /* Pagination */
        .pagination-container {
            padding: 8px;
            text-align: center;
            border-top: 1px solid var(--facebook-border);
        }

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

        @media (max-width: 768px) {
            .profile-picture {
                width: 120px;
                height: 120px;
            }
        }
    </style>
@endsection
