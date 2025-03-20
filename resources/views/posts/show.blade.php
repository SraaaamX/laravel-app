@extends('layouts.app')

@section('content')
    <div class="post-container">
        <!-- Post Card -->
        <div class="post-box">
            <!-- Post Header -->
            <div class="post-header">
                <div class="post-author">
                    <a
                        href="{{ Auth::check() && Auth::id() === $post->author_id ? route('profile') : route('profile.public', $post->author->username) }}">
                        <img src="{{ $post->author->profile_pic ? asset('storage/' . $post->author->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($post->author->name) }}"
                            alt="Photo de profil">
                    </a>
                    <div class="author-info">
                        <a href="{{ Auth::check() && Auth::id() === $post->author_id ? route('profile') : route('profile.public', $post->author->username) }}"
                            class="author-name">{{ $post->author->name }}</a>
                        <span class="post-time">{{ $post->created_at->format('d/m/Y \\à H:i') }}</span>
                    </div>
                </div>

                @if (Auth::check() && Auth::id() === $post->author_id)
                    <div class="post-actions">
                        <a href="{{ route('posts.edit', $post->id) }}" class="action-link">Modifier</a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-link danger"
                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce post ?')">
                                Supprimer
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Post Content -->
            <div class="post-content">
                @if ($post->post_resource)
                    <div class="post-media">
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
                <p class="post-description">{{ $post->description }}</p>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="comments-section">
            <div class="comments-header">
                <h3>Commentaires</h3>
            </div>

            <!-- Comment Form -->
            <div class="comment-form-container">
                <form action="{{ route('comments.store', $post->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="content" class="form-input @error('content') is-invalid @enderror" rows="2"
                            placeholder="Écrire un commentaire..."></textarea>
                        @error('content')
                            <div class="error-text">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Commenter</button>
                    </div>
                </form>
            </div>

            <!-- Comments List -->
            <div class="comments-list">
                @foreach ($comments as $comment)
                    <div class="comment-box">
                        <div class="comment-header">
                            <div class="comment-author">
                                <a
                                    href="{{ Auth::id() === $comment->user_id ? route('profile') : route('profile.public', $comment->user->username) }}">
                                    <img src="{{ $comment->user->profile_pic ? asset('storage/' . $comment->user->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) }}"
                                        alt="Photo de profil">
                                </a>
                                <div>
                                    <a href="{{ Auth::id() === $comment->user_id ? route('profile') : route('profile.public', $comment->user->username) }}"
                                        class="author-name">{{ $comment->user->name }}</a>
                                    <span class="comment-time">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>

                            @if (Auth::id() === $comment->user_id)
                                <div class="comment-actions">
                                    <button type="button" class="action-link" data-bs-toggle="modal"
                                        data-bs-target="#editComment{{ $comment->id }}">
                                        Modifier
                                    </button>
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-link danger"
                                            onclick="return confirm('Voulez-vous vraiment supprimer ce commentaire ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>

                                <!-- Edit Comment Modal -->
                                <div class="modal fade" id="editComment{{ $comment->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5>Modifier le commentaire</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('comments.update', $comment->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <textarea name="content" class="form-input" rows="3">{{ $comment->content }}</textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <p class="comment-content">{{ $comment->content }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                {{ $comments->links() }}
            </div>
        </div>

        <!-- Back Button -->
        <div class="back-button">
            <a href="{{ url()->previous() }}" class="action-link">← Retour</a>
        </div>
    </div>

    <style>
        .post-container {
            max-width: 850px;
            margin: 20px auto;
            padding: 0 15px;
        }

        .post-box {
            background: white;
            border: 1px solid var(--facebook-border);
            margin-bottom: 20px;
        }

        .post-header {
            background: var(--facebook-light-blue);
            padding: 8px 10px;
            border-bottom: 1px solid var(--facebook-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .post-author {
            display: flex;
            align-items: center;
        }

        .post-author img {
            width: 32px;
            height: 32px;
            margin-right: 8px;
            border: 1px solid var(--facebook-border);
            border-radius: 2px;
        }

        .author-info {
            display: flex;
            flex-direction: column;
        }

        .author-name {
            color: var(--facebook-link);
            font-weight: bold;
            text-decoration: none;
            font-size: 11px;
        }

        .post-time,
        .comment-time {
            color: #666;
            font-size: 10px;
        }

        .post-content {
            padding: 10px;
        }

        .post-media img,
        .post-media video {
            max-width: 100%;
            display: block;
            margin: 0 auto 10px;
        }

        .post-description {
            font-size: 11px;
            color: var(--facebook-text);
            margin: 0;
        }

        .comments-section {
            background: white;
            border: 1px solid var(--facebook-border);
            margin-bottom: 20px;
        }

        .comments-header {
            background: var(--facebook-light-blue);
            padding: 8px 10px;
            border-bottom: 1px solid var(--facebook-border);
        }

        .comments-header h3 {
            margin: 0;
            font-size: 11px;
            font-weight: bold;
            color: var(--facebook-text);
        }

        .comment-form-container {
            padding: 10px;
            border-bottom: 1px solid var(--facebook-border);
        }

        .form-input {
            width: 100%;
            padding: 3px;
            border: 1px solid #bdc7d8;
            font-size: 11px;
        }

        .form-input:focus {
            border-color: #3b5998;
        }

        .form-actions {
            text-align: right;
            margin-top: 5px;
        }

        .comments-list {
            padding: 10px;
        }

        .comment-box {
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--facebook-border);
        }

        .comment-box:last-child {
            border-bottom: none;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
        }

        .comment-author {
            display: flex;
            align-items: center;
        }

        .comment-author img {
            width: 32px;
            height: 32px;
            margin-right: 8px;
            border: 1px solid var(--facebook-border);
            border-radius: 2px;
        }

        .comment-content {
            font-size: 11px;
            color: var(--facebook-text);
            margin: 5px 0 0 40px;
        }

        .action-link {
            color: var(--facebook-link);
            text-decoration: none;
            font-size: 11px;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .action-link:hover {
            text-decoration: underline;
        }

        .action-link.danger {
            color: var(--danger);
        }

        .delete-form {
            display: inline;
        }

        .pagination-container {
            padding: 10px;
            text-align: center;
            border-top: 1px solid var(--facebook-border);
        }

        .back-button {
            margin: 20px 0;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 3px;
            border: 1px solid var(--facebook-border);
        }

        .modal-header {
            background: var(--facebook-light-blue);
            padding: 8px 10px;
            border-bottom: 1px solid var(--facebook-border);
        }

        .modal-header h5 {
            color: var(--facebook-text);
            font-size: 11px;
            font-weight: bold;
            margin: 0;
        }

        .modal-body {
            padding: 10px;
        }

        .modal-footer {
            background: var(--facebook-light-blue);
            padding: 8px 10px;
            border-top: 1px solid var(--facebook-border);
        }

        .btn {
            font-size: 11px;
            padding: 2px 6px;
        }

        .btn-primary {
            background: #5b74a8;
            background-image: linear-gradient(#637bad, #5872a7);
            border: 1px solid;
            border-color: #29447e #29447e #1a356e;
            color: white;
            font-weight: bold;
        }

        .btn-secondary {
            background: #f0f0f0;
            border: 1px solid #999;
            color: #333;
        }

        .error-text {
            color: var(--danger);
            font-size: 11px;
            margin-top: 2px;
        }
    </style>
@endsection
