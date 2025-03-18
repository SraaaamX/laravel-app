@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-smooth border-0">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Nouvelle Publication</h4>

                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="post_resource" class="form-label">Media (Image/Vidéo)</label>
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
                                    rows="4" required>{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Retour
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cloud-upload me-2"></i>Publier
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
