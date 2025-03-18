@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-smooth border-0">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Modifier la Publication</h4>

                        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if ($post->post_resource)
                                <div class="mb-4">
                                    <label class="form-label">Media actuel</label>
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $post->post_resource) }}" alt="Current media"
                                            class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            @endif

                            <div class="mb-4">
                                <label for="post_resource" class="form-label">Changer le media (Image/Vidéo)</label>
                                <input type="file" class="form-control @error('post_resource') is-invalid @enderror"
                                    id="post_resource" name="post_resource" accept="image/*,video/mp4">
                                @error('post_resource')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Formats acceptés: jpeg, png, jpg, gif, mp4. Taille max: 10MB</div>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" required>{{ old('description', $post->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Retour
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save me-2"></i>Enregistrer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
