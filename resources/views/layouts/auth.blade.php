<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BNN News - Autentikasi</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('dashui-assets/css/theme.css') }}">

</head>

<body>
    <main class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center g-0 min-vh-100">
            <div class="col-xxl-4 col-lg-6 col-md-8 col-12 py-8 py-xl-0">
                <!-- Card -->
                <div class="card smooth-shadow-md">
                    <!-- Card body -->
                    <div class="card-body p-6">
                        <div class="mb-4">
                            <a href="/" class="text-inherit fs-3 fw-bold"><h1 class="mb-2">BNN News</h1></a>
                            <p class="mb-6">@yield('card-title')</p>
                        </div>
                        <!-- Form -->
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    @stack('scripts')
</body>

</html>
