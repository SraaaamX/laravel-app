@extends('layouts.app')

@section('content')
    <div class="form-container">
        <div class="form-box">
            <div class="form-header">
                <h2>Modifier la Publication</h2>
            </div>

            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data"
                class="post-form">
                @csrf
                @method('PUT')

                @if ($post->post_resource)
                    <div class="form-group">
                        <label>Media actuel</label>
                        <div class="current-media">
                            <img src="{{ asset('storage/' . $post->post_resource) }}" alt="Media actuel">
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label>Changer le media (Image/Vidéo)</label>
                    <input type="file" class="form-input @error('post_resource') is-invalid @enderror"
                        name="post_resource" accept="image/*,video/mp4">
                    <small class="help-text">Formats acceptés: jpeg, png, jpg, gif, mp4, webp. Taille max: 10MB</small>
                    @error('post_resource')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-input @error('description') is-invalid @enderror" name="description" rows="4" required>{{ old('description', $post->description) }}</textarea>
                    @error('description')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('profile') }}" class="btn btn-secondary">Retour</a>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .form-container {
            width: 980px;
            margin: 20px auto;
            display: flex;
            justify-content: center;
        }

        .form-box {
            background: white;
            border: 1px solid var(--facebook-border);
            width: 500px;
            padding: 0;
        }

        .form-header {
            background: var(--facebook-light-blue);
            padding: 8px 10px;
            border-bottom: 1px solid var(--facebook-border);
        }

        .form-header h2 {
            color: var(--facebook-text);
            font-size: 13px;
            font-weight: bold;
            margin: 0;
        }

        .post-form {
            padding: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            color: var(--facebook-text);
            margin-bottom: 3px;
        }

        .current-media {
            border: 1px solid var(--facebook-border);
            padding: 3px;
            text-align: center;
            margin-bottom: 5px;
            background: white;
        }

        .current-media img {
            max-width: 100%;
            max-height: 200px;
            display: block;
            margin: 0 auto;
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

        .form-input.is-invalid {
            border-color: var(--danger);
            background: #ffebe8;
        }

        .help-text {
            display: block;
            color: #666;
            font-size: 11px;
            margin-top: 2px;
        }

        .error-text {
            color: var(--danger);
            font-size: 11px;
            margin-top: 2px;
        }

        .form-actions {
            border-top: 1px solid var(--facebook-border);
            padding-top: 10px;
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        textarea.form-input {
            resize: vertical;
            min-height: 60px;
        }
    </style>
@endsection
