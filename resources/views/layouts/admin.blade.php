<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Desa Sidokerto</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        body { background-color: #f8f9fa; }
        .sidebar {
            position: fixed; top: 0; bottom: 0; left: 0; z-index: 100;
            padding: 48px 0 0; box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        .sidebar-sticky { position: relative; top: 0; height: calc(100vh - 48px); padding-top: .5rem; overflow-x: hidden; overflow-y: auto; }
        .nav-link { font-weight: 500; color: #333; }
        .nav-link:hover { color: #0d6efd; }
        .nav-link.active { color: #0d6efd; font-weight: bold; }
        /* Agar konten tidak tertutup sidebar di layar besar */
        .main-content { margin-left: 220px; } 
        /* Penyesuaian untuk layar kecil */
        @media (max-width: 767.98px) {
            .sidebar { top: 5rem; padding-top: .5rem; }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark fixed-top p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Desa Sidokerto</a>
    
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <ul class="navbar-nav flex-row ms-auto me-3 align-items-center">
        <li class="nav-item me-3 d-none d-md-block">
            <span class="text-white">
                Hai, <strong>{{ Auth::user()->name }}</strong> 
                <span class="badge bg-secondary ms-1">{{ ucfirst(Auth::user()->role) }}</span>
            </span>
        </li>

        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-dark btn-sm border-white" onclick="return confirm('Yakin ingin logout?')">
                    Logout <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="sidebar-sticky pt-3">
                <ul class="nav flex-column">
                    
                    @if(Auth::user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i> Dashboard Admin
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('biodata.*') ? 'active' : '' }}" href="{{ route('biodata.index') }}">
                                <i class="fas fa-users me-2"></i> Biodata Penduduk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('berita.*') ? 'active' : '' }}" href="{{ route('berita.index') }}">
                                <i class="fas fa-newspaper me-2"></i> Kelola Berita
                            </a>
                        </li>
                    
                    @elseif(Auth::user()->role == 'warga')
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('warga.dashboard') ? 'active' : '' }}" href="{{ route('warga.dashboard') }}">
                                <i class="fas fa-home me-2"></i> Portal Warga
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-envelope me-2"></i> Ajukan Surat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-bullhorn me-2"></i> Buat Pengaduan
                            </a>
                        </li>
                    @endif

                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span>Menu Umum</span>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">
                            <i class="fas fa-globe me-2"></i> Ke Halaman Depan
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content pt-5 mt-3">
            <div class="pt-3 pb-2 mb-3 border-bottom">
                @yield('content')
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>