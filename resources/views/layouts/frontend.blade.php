<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'BNN News - Berita Terkini dan Terpercaya')</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('dashui-assets/css/theme.css') }}">

</head>
<body>

    <!-- Navbar -->
    <div class="navbar-expand-lg">
        <div class="container px-0">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="{{ route('home') }}"><h2>BNN News</h2></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="{{ route('login') }}">Masuk</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </nav>
        </div>
    </div>

    <!-- Main Content -->
    <main class="container my-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
            <span class="text-muted">© {{ date('Y') }} BNN News. All Rights Reserved.</span>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('dashui-assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('dashui-assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
