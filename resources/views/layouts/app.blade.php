<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Réseau Social Laravel') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #1a56db;
            --primary-hover: #1e429f;
            --secondary-color: #64748b;
            --success-color: #059669;
            --danger-color: #dc2626;
            --background-light: #f1f5f9;
            --background-white: #ffffff;
            --text-color: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --transition-speed: 0.2s;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        html {
            height: 100%;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
            background-color: var(--background-light);
            min-height: 100%;
            display: flex;
            flex-direction: column;
            transition: all var(--transition-speed);
            line-height: 1.6;
            letter-spacing: -0.025em;
        }

        main {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
            background-color: var(--background-white) !important;
            border-color: var(--border-color) !important;
            padding: 2rem 0;
        }

        .navbar {
            background-color: var(--background-white) !important;
            border-bottom: 1px solid var(--border-color);
            transition: all var(--transition-speed);
            padding-top: 1rem;
            padding-bottom: 1rem;
            box-shadow: var(--shadow-sm);
        }

        .navbar-brand {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-color);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all var(--transition-speed);
        }

        .nav-link:hover {
            color: var(--primary-color);
            background-color: var(--background-light);
        }

        .btn {
            font-weight: 500;
            padding: 0.625rem 1.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            border-color: var(--primary-hover);
        }

        .btn-outline-danger {
            color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-outline-danger:hover {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
            color: white;
        }

        .card {
            border-radius: 1rem;
            border: 1px solid var(--border-color);
            transition: all var(--transition-speed);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .alert {
            border: none;
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background-color: #ecfdf5;
            color: var(--success-color);
        }

        .alert-danger {
            background-color: #fef2f2;
            color: var(--danger-color);
        }

        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            border-bottom: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid var(--border-color);
            padding: 1.5rem;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all var(--transition-speed);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(26, 86, 219, 0.1);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Réseau Social') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item me-2">
                            <a class="nav-link d-flex align-items-center" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-2"></i> Se connecter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Créer un compte
                            </a>
                        </li>
                    @else
                        <li class="nav-item me-3">
                            <a class="nav-link d-flex align-items-center" href="{{ route('profile') }}">
                                <i class="bi bi-person-circle me-2"></i> {{ Auth::user()->username }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#logoutConfirmModal">
                                <i class="bi bi-box-arrow-right"></i> Déconnexion
                            </button>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal de confirmation de déconnexion -->
    <div class="modal fade" id="logoutConfirmModal" tabindex="-1" aria-labelledby="logoutConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutConfirmModalLabel">Confirmation de déconnexion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir vous déconnecter ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Confirmer la déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <main class="container py-5 fade-in">
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
    <footer class="footer mt-5 border-top bg-white">
        <div class="container">
            <div class="text-center">
                <p class="mb-0 text-muted">&copy; {{ date('Y') }} Réseau Social Laravel</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>
