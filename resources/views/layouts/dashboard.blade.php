<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>BNN News - Dashboard</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('dashui-assets/css/theme.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

</head>

<body>
    <div id="db-wrapper">
        <!-- navbar vertical -->
        <div class="navbar-vertical navbar">
            <div class="nav-scroller">
                <!-- Brand logo -->
                <a class="navbar-brand" href="/">
                    <h1 class="h1 text-white mb-0">BNN News</h1>
                </a>
                <!-- Navbar nav -->
                <ul class="navbar-nav flex-column" id="sideNavbar">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="nav-icon bi bi-house-door me-2"></i> Dashboard
                        </a>
                    </li>

                    @if (Auth::user()->role->name == 'Wartawan' || Auth::user()->role->name == 'Editor')
                    <li class="nav-item">
                        <div class="navbar-heading">Manajemen Berita</div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('posts.*') ? 'active' : '' }}" href="{{ route('posts.index') }}">
                            <i class="nav-icon bi bi-file-text me-2"></i> Manajemen Postingan
                        </a>
                    </li>
                    @endif
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#!">
                            <i class="nav-icon bi bi-newspaper me-2"></i> Semua Berita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#!">
                            <i class="nav-icon bi bi-pencil-square me-2"></i> Tulis Berita
                        </a>
                    </li> -->

                    @if (Auth::user()->role->name == 'Admin')
                    <li class="nav-item">
                        <div class="navbar-heading">Pengaturan Admin</div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                            <i class="nav-icon bi bi-tags me-2"></i> Manajemen Kategori
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="nav-icon bi bi-people me-2"></i> Manajemen User
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <!-- / navbar vertical -->

        <!-- page content -->
        <div id="page-content">
            <div class="header">
                <!-- navbar -->
                <nav class="navbar-classic navbar navbar-expand-lg">
                    <div class="d-flex justify-content-between w-100">
                        <div class="d-flex align-items-center">
                            <a href="#" id="nav-toggle" class="nav-icon me-2 icon-xs">
                                <i class="bi bi-list"></i>
                            </a>
                        </div>
                        <!--/.nav-right-wrap -->
                        <ul class="navbar-nav navbar-right-wrap ms-2 d-flex nav-top-wrap">
                            <!-- profile -->
                            <li class="dropdown ms-2">
                                <a class="rounded-circle" href="#!" role="button" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-md avatar-indicators avatar-online">
                                        <img alt="avatar" src="{{ asset('dashui-assets/images/avatar/avatar-1.jpg') }}" class="rounded-circle" />
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                                    <div class="dropdown-item">
                                        <div class="d-flex">
                                            <div class="avatar avatar-md avatar-indicators avatar-online">
                                                <img alt="avatar" src="{{ asset('dashui-assets/images/avatar/avatar-1.jpg') }}" class="rounded-circle" />
                                            </div>
                                            <div class="ms-3 lh-1">
                                                <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                                                <p class="mb-0 text-muted">{{ Auth::user()->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <ul class="list-unstyled">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <i class="me-2 bi bi-person-circle"></i>Edit Profile
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="dropdown-divider"></div>
                                    <ul class="list-unstyled">
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                    <i class="me-2 bi bi-power"></i>Sign Out
                                                </a>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="container-fluid p-4">
                <div class="row mb-4">
                    <div class="col-12">
                        @yield('page-header')
                    </div>
                </div>
                @yield('content')
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
