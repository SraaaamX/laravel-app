@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-4">Partagez vos moments<br>spéciaux</h1>
                    <p class="lead mb-4">Créez des connexions authentiques, partagez vos expériences et découvrez des
                        histoires inspirantes dans notre communauté dynamique.</p>
                    @guest
                        <div class="d-grid gap-3 d-sm-flex">
                            <a href="{{ route('register') }}"
                                class="btn btn-primary btn-lg px-5 py-3 me-sm-3 fw-bold">Rejoignez-nous</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-5 py-3">Connexion</a>
                        </div>
                    @else
                        <div class="d-grid gap-3 d-sm-flex">
                            <a href="{{ route('profile') }}" class="btn btn-primary btn-lg px-5 py-3 fw-bold">Voir mon
                                Profil</a>
                        </div>
                    @endguest
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0 text-center">
                    <img src="https://placehold.co/600x400/e9ecef/495057?text=Communauté+Sociale" alt="Community"
                        class="img-fluid rounded-4 shadow-lg">
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="d-inline-block bg-primary bg-opacity-10 p-3 rounded-circle mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-people-fill text-primary" viewBox="0 0 16 16">
                            <path
                                d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                        </svg>
                    </div>
                    <h3 class="h4 mb-3">Communauté Active</h3>
                    <p class="text-muted mb-0">Rejoignez une communauté dynamique de personnes partageant les mêmes centres
                        d'intérêt.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="d-inline-block bg-primary bg-opacity-10 p-3 rounded-circle mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-shield-check text-primary" viewBox="0 0 16 16">
                            <path
                                d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7.4 7.4 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.4 7.4 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.5 62.5 0 0 1 5.072.56" />
                        </svg>
                    </div>
                    <h3 class="h4 mb-3">Sécurisé</h3>
                    <p class="text-muted mb-0">Profitez d'un environnement sûr et sécurisé pour partager vos moments.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white rounded-4 shadow-sm h-100">
                    <div class="d-inline-block bg-primary bg-opacity-10 p-3 rounded-circle mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-chat-dots text-primary" viewBox="0 0 16 16">
                            <path
                                d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                            <path
                                d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.4 10.4 0 0 1-.524 2.318l-.003.011a10.7 10.7 0 0 1-.244.637c-.079.186.074.394.273.362a21.8 21.8 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2" />
                        </svg>
                    </div>
                    <h3 class="h4 mb-3">Interactions Riches</h3>
                    <p class="text-muted mb-0">Partagez, commentez et interagissez avec d'autres membres de manière
                        significative.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="bg-light py-5">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <h2 class="display-4 fw-bold text-primary mb-2">10k+</h2>
                    <p class="text-muted h5">Utilisateurs Actifs</p>
                </div>
                <div class="col-md-4">
                    <h2 class="display-4 fw-bold text-primary mb-2">50k+</h2>
                    <p class="text-muted h5">Moments Partagés</p>
                </div>
                <div class="col-md-4">
                    <h2 class="display-4 fw-bold text-primary mb-2">100k+</h2>
                    <p class="text-muted h5">Interactions</p>
                </div>
            </div>
        </div>
    </div>
@endsection
