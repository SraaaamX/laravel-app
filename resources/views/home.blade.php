@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4 mb-4">Bienvenue</h1>
                <p class="lead mb-5">Connectez-vous avec des personnes et partagez vos moments</p>

                @guest
                    <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 me-sm-3">Connexion</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg px-4">Inscription</a>
                    </div>
                @else
                    <p>Vous êtes connecté!</p>
                    <a href="{{ route('profile') }}" class="btn btn-primary btn-lg">Voir le profil</a>
                @endguest
            </div>
        </div>
    </div>
@endsection
