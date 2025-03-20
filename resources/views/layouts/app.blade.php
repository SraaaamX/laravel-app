<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Réseau Social Laravel') }}</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        @font-face {
            font-family: 'Lucida Grande';
            src: local('Lucida Grande');
        }

        :root {
            --facebook-blue: #3b5998;
            --facebook-hover: #2f477a;
            --facebook-light-blue: #d8dfea;
            --facebook-grey: #f2f2f2;
            --facebook-border: #c4cde0;
            --facebook-text: #141823;
            --facebook-link: #3b5998;
            --white: #ffffff;
            --danger: #ce0814;
        }

        body {
            font-family: 'Lucida Grande', 'Tahoma', 'Verdana', sans-serif;
            font-size: 11px;
            color: var(--facebook-text);
            background-color: var(--facebook-grey);
            line-height: 1.28;
            margin: 0;
        }

        .navbar {
            background-color: var(--facebook-blue);
            background-image: linear-gradient(#4e69a2, #3b5998 50%);
            border-bottom: 1px solid #133783;
            box-shadow: 0 2px 2px -2px rgba(0, 0, 0, .52);
            padding: 0;
            height: 42px;
            min-width: 980px;
        }

        .container {
            width: 980px;
            padding: 0 10px;
            margin: 0 auto;
        }

        .navbar-brand {
            color: var(--white) !important;
            font-size: 20px;
            font-weight: bold;
            padding: 8px 0;
            text-shadow: 0 1px 1px #333;
        }

        .navbar-nav {
            height: 42px;
            display: flex;
            align-items: center;
        }

        .nav-link {
            color: var(--white) !important;
            font-size: 12px;
            padding: 4px 10px !important;
            font-weight: bold;
            text-shadow: 0 -1px rgba(0, 0, 0, .5);
        }

        .nav-link:hover {
            background-color: var(--facebook-hover);
            text-decoration: none;
        }

        .btn {
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 2px;
            font-weight: bold;
        }

        .btn-primary {
            background: #5b74a8;
            background-image: linear-gradient(#637bad, #5872a7);
            border: 1px solid #29487d;
            color: var(--white);
            text-shadow: 0 -1px 0 rgba(0, 0, 0, .2);
        }

        .btn-primary:hover {
            background: #4f6aa3;
        }

        .btn-danger {
            background: #ce0814;
            border-color: #a50610;
            color: var(--white);
        }

        .card {
            border-radius: 3px;
            border: 1px solid var(--facebook-border);
            background: var(--white);
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, .15);
        }

        .card-header {
            background: var(--facebook-light-blue);
            padding: 6px 8px;
            font-weight: bold;
            font-size: 11px;
            color: var(--facebook-text);
            border-bottom: 1px solid var(--facebook-border);
        }

        .alert {
            border-radius: 3px;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid transparent;
        }

        .alert-success {
            background-color: #e9ffd9;
            border-color: #98c687;
            color: #1e4620;
        }

        .alert-danger {
            background-color: #ffebe8;
            border-color: #dd3c10;
            color: #ce0814;
        }

        .modal-content {
            border-radius: 3px;
            border: 1px solid var(--facebook-border);
        }

        .modal-header {
            background: #f2f2f2;
            padding: 10px 15px;
            border-bottom: 1px solid var(--facebook-border);
        }

        .modal-body {
            padding: 15px;
            color: var(--facebook-text);
        }

        .modal-footer {
            background: #f2f2f2;
            padding: 10px 15px;
            border-top: 1px solid var(--facebook-border);
        }

        .form-control {
            border-radius: 0;
            border: 1px solid #bdc7d8;
            padding: 3px;
            font-size: 11px;
        }

        main {
            width: 980px;
            margin: 20px auto;
            background: var(--white);
            padding: 15px;
            border: 1px solid var(--facebook-border);
            border-radius: 3px;
            min-height: 600px;
        }

        footer {
            width: 980px;
            margin: 0 auto;
            color: #737373;
            font-size: 11px;
            padding: 15px 0;
        }

        footer a {
            color: #3b5998;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .fade-in {
            animation: none;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Réseau Social') }}</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item me-2">
                            <a class="nav-link" href="{{ route('login') }}">
                                Se connecter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('register') }}">
                                S'inscrire
                            </a>
                        </li>
                    @else
                        <li class="nav-item me-3">
                            <a class="nav-link d-flex align-items-center" href="{{ route('profile') }}">
                                <img src="{{ Auth::user()->profile_pic ? asset('storage/' . Auth::user()->profile_pic) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) }}"
                                    alt="Photo de profil" width="20" height="20" class="rounded-circle me-2">
                                {{ Auth::user()->username }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#logoutConfirmModal">
                                Déconnexion
                            </button>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal de confirmation de déconnexion -->
    <div class="modal fade" id="logoutConfirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmation de déconnexion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir vous déconnecter ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <main>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <span>&copy; {{ date('Y') }} {{ config('app.name', 'Réseau Social Laravel') }}</span>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>
