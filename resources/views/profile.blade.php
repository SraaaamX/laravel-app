@extends('layouts.app')

@section('content')
    <div class="profile-container">
        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-picture-container">
                @if (auth()->user()->profile_pic)
                    <img src="{{ asset('storage/' . auth()->user()->profile_pic) }}" alt="Photo de profil"
                        class="profile-picture">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                        alt="Photo de profil par défaut" class="profile-picture">
                @endif
            </div>
            <h1 class="profile-name">{{ auth()->user()->name }}</h1>
        </div>

        <!-- Profile Content -->
        <div class="content-columns">
            <!-- Left Column -->
            <div class="left-column">
                <div class="info-section">
                    <h3>Informations</h3>
                    @if (session('profile_error'))
                        <div class="error-message">
                            {{ session('profile_error') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                        class="profile-form">
                        @csrf
                        <!-- Photo de profil -->
                        <div class="form-group">
                            <label>Photo de profil</label>
                            <input type="file" name="profile_pic" accept="image/*" class="form-input">
                            @error('profile_pic')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="form-group">
                            <label>Nom d'utilisateur</label>
                            <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}"
                                class="form-input" required>
                            @error('username')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                class="form-input" required>
                            @error('email')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bio -->
                        <div class="form-group">
                            <label>Biographie</label>
                            <textarea name="bio" rows="3" class="form-input">{{ old('bio', auth()->user()->bio) }}</textarea>
                            @error('bio')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Mettre à jour le profil</button>
                        </div>
                    </form>

                    <div class="account-actions">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">Modifier le mot de passe</button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteConfirmModal">Supprimer le compte</button>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="right-column">
                <div class="posts-section">
                    <div class="posts-header">
                        <h3>Mes Publications</h3>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary">Nouvelle publication</a>
                    </div>

                    @if (count(auth()->user()->posts) > 0)
                        <div class="posts-grid">
                            @foreach (auth()->user()->posts as $post)
                                <div class="post-card">
                                    @if ($post->post_resource)
                                        <div class="post-image">
                                            <img src="{{ asset('storage/' . $post->post_resource) }}" alt="Post media">
                                        </div>
                                    @endif
                                    <div class="post-content">
                                        <p>{{ Str::limit($post->description, 100) }}</p>
                                        <div class="post-actions">
                                            <div class="action-buttons">
                                                <a href="{{ route('posts.edit', $post->id) }}"
                                                    class="action-link">Modifier</a>
                                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                                    class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-link danger">Supprimer</button>
                                                </form>
                                            </div>
                                            <span class="likes-count">{{ $post->likesNumber }} likes</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-posts">
                            <p>Aucune publication</p>
                            <p>Commencez à partager vos moments avec la communauté !</p>
                            <a href="{{ route('posts.create') }}" class="btn btn-primary">Créer ma première publication</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Modifier le mot de passe</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('profile.updatePassword') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Mot de passe actuel</label>
                            <input type="password" name="current_password" class="form-input" required>
                            @error('current_password')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Nouveau mot de passe</label>
                            <input type="password" name="new_password" class="form-input" required>
                            @error('new_password')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                            <small class="help-text">Le mot de passe doit contenir au moins 8 caractères</small>
                        </div>
                        <div class="form-group">
                            <label>Confirmer le nouveau mot de passe</label>
                            <input type="password" name="new_password_confirmation" class="form-input" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Modifier le mot de passe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Confirmation de suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible et supprimera toutes
                        vos données.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('profile.delete') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
                    </form>
                </div>
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
            margin: 0;
        }

        .content-columns {
            display: flex;
            gap: 20px;
        }

        .left-column {
            width: 320px;
            flex-shrink: 0;
        }

        .right-column {
            flex: 1;
            max-width: 500px;
        }

        .info-section {
            background: white;
            border: 1px solid var(--facebook-border);
            margin-bottom: 20px;
        }

        .info-section h3 {
            background: var(--facebook-light-blue);
            border-bottom: 1px solid var(--facebook-border);
            margin: 0;
            padding: 6px 8px;
            font-size: 11px;
            font-weight: bold;
            color: var(--facebook-text);
        }

        .profile-form {
            padding: 10px;
        }

        .form-group {
            margin-bottom: 8px;
        }

        .form-group label {
            display: block;
            color: var(--facebook-text);
            font-size: 11px;
            margin-bottom: 2px;
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

        .error-message {
            background: #ffebe8;
            border: 1px solid #dd3c10;
            padding: 8px;
            margin: 8px;
            color: var(--danger);
            font-size: 11px;
        }

        .error-text {
            color: var(--danger);
            font-size: 11px;
            margin-top: 2px;
        }

        .help-text {
            color: #666;
            font-size: 11px;
        }

        .form-actions {
            padding: 8px;
            border-top: 1px solid var(--facebook-border);
            margin-top: 10px;
            text-align: right;
        }

        .account-actions {
            padding: 8px;
            border-top: 1px solid var(--facebook-border);
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .posts-section {
            background: white;
            border: 1px solid var(--facebook-border);
        }

        .posts-header {
            background: var(--facebook-light-blue);
            border-bottom: 1px solid var(--facebook-border);
            padding: 6px 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        }

        .post-image {
            border-bottom: 1px solid var(--facebook-border);
            max-height: 250px;
            overflow: hidden;
        }

        .post-image img {
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

        .post-actions {
            border-top: 1px solid var(--facebook-border);
            padding-top: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
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

        .likes-count {
            color: #666;
            font-size: 11px;
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

        .delete-form {
            display: inline;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 3px;
            border: 1px solid var(--facebook-border);
        }

        .modal-header {
            background: var(--facebook-light-blue);
            padding: 6px 8px;
            border-bottom: 1px solid var(--facebook-border);
        }

        .modal-header h5 {
            color: var(--facebook-text);
            font-size: 11px;
            font-weight: bold;
            margin: 0;
        }

        .modal-body {
            padding: 8px;
            font-size: 11px;
            color: var(--facebook-text);
        }

        .modal-footer {
            background: var(--facebook-light-blue);
            padding: 6px 8px;
            border-top: 1px solid var(--facebook-border);
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
        }

        .btn-secondary {
            background: #f0f0f0;
            border: 1px solid #999;
            color: #333;
        }

        .btn-danger {
            background: #ee3d2e;
            border: 1px solid #c43c35;
            color: white;
            font-weight: bold;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 60px;
        }

        @media (max-width: 768px) {
            .content-columns {
                flex-direction: column;
            }

            .left-column {
                width: 100%;
            }

            .right-column {
                max-width: 100%;
            }
        }
    </style>
@endsection
