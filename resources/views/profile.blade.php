@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-smooth border-0">
                    <div class="bg-primary text-white text-center py-5 position-relative">
                        <div class="position-absolute w-100" style="bottom: -50px">
                            @if (auth()->user()->profile_pic)
                                <img src="{{ asset('storage/' . auth()->user()->profile_pic) }}" alt="Profile Picture"
                                    class="rounded-circle border border-4 border-white shadow-sm"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                                    alt="Default Profile Picture"
                                    class="rounded-circle border border-4 border-white shadow-sm"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                        </div>
                    </div>

                    <div class="card-body pt-5 mt-4">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="mb-4">
                                        <label for="profile_pic" class="form-label text-sm font-medium">Photo de
                                            profil</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-image text-muted"></i>
                                            </span>
                                            <input type="file"
                                                class="form-control border-start-0 ps-0 @error('profile_pic') is-invalid @enderror"
                                                id="profile_pic" name="profile_pic" accept="image/*">
                                        </div>
                                        @error('profile_pic')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="username" class="form-label text-sm font-medium">Nom
                                            d'utilisateur</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-person text-muted"></i>
                                            </span>
                                            <input type="text"
                                                class="form-control border-start-0 ps-0 @error('username') is-invalid @enderror"
                                                id="username" name="username"
                                                value="{{ old('username', auth()->user()->username) }}" required>
                                        </div>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="email" class="form-label text-sm font-medium">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-envelope text-muted"></i>
                                            </span>
                                            <input type="email"
                                                class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror"
                                                id="email" name="email"
                                                value="{{ old('email', auth()->user()->email) }}" required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="bio" class="form-label text-sm font-medium">Biographie</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-journal-text text-muted"></i>
                                            </span>
                                            <textarea class="form-control border-start-0 ps-0 @error('bio') is-invalid @enderror" id="bio" name="bio"
                                                rows="3" placeholder="Parlez-nous un peu de vous...">{{ old('bio', auth()->user()->bio) }}</textarea>
                                        </div>
                                        @error('bio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-grid gap-3">
                                        <button type="submit" class="btn btn-primary rounded-pill py-2 hover-lift">
                                            <i class="bi bi-check2-circle me-2"></i>Mettre à jour le profil
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
