<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Réseau Social Laravel') }}</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --background-light: #f8f9fa;
            --background-white: #ffffff;
            --text-color: #212529;
            --text-muted: #6c757d;
            --border-color: #dee2e6;
            --transition-speed: 0.2s;
        }

        [data-bs-theme="dark"] {
            --background-light: #1a1d20;
            --background-white: #212529;
            --text-color: #f8f9fa;
            --text-muted: #adb5bd;
            --border-color: #2d3238;
        }

        html {
            height: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--text-color);
            background-color: var(--background-light);
            min-height: 100%;
            display: flex;
            flex-direction: column;
            transition: all var(--transition-speed);
        }

        main {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
            background-color: var(--background-white) !important;
            border-color: var(--border-color) !important;
        }

        .navbar {
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            transition: all var(--transition-speed);
        }

        .nav-link,
        .btn {
            transition: all var(--transition-speed);
        }

        .btn-primary {
            border-radius: 50rem;
            padding: 0.5rem 1.5rem;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .card {
            border-radius: 1rem;
            border: 1px solid var(--border-color);
            transition: all var(--transition-speed);
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .1);
        }

        .shadow-smooth {
            box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm sticky-top">
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
                                <i class="bi bi-box-arrow-in-right me-1"></i> Se connecter
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary rounded-pill" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i> Créer un compte
                            </a>
                        </li>
                    @else
                        <li class="nav-item me-3">
                            <a class="nav-link d-flex align-items-center" href="{{ route('profile') }}">
                                <i class="bi bi-person-circle me-1"></i> Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger rounded-pill">
                                    <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="container py-5">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer py-4 mt-5 border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 text-muted">&copy; {{ date('Y') }} Réseau Social Laravel</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                    <button class="btn btn-outline-secondary rounded-pill" id="themeToggle">
                        <i class="bi bi-moon-stars"></i>
                        <span class="ms-1 d-none d-md-inline">Thème</span>
                    </button>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Theme Toggle Script -->
    <script>
        document.getElementById('themeToggle').addEventListener('click', function() {
            if (document.documentElement.getAttribute('data-bs-theme') === 'dark') {
                document.documentElement.setAttribute('data-bs-theme', 'light');
                this.innerHTML =
                    '<i class="bi bi-moon-stars"></i><span class="ms-1 d-none d-md-inline">Thème</span>';
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                this.innerHTML = '<i class="bi bi-sun"></i><span class="ms-1 d-none d-md-inline">Thème</span>';
            }
        });
    </script>
</body>

</html>
