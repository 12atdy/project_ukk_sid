<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Desa Sidokerto</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { 
            background-color: #f3f4f6; 
            font-family: 'Inter', sans-serif;
        }

        /* --- GAYA NAVBAR MENGAMBANG --- */
        .navbar-floating {
            top: 15px; 
            left: 15px; 
            right: 15px; 
            width: auto; 
            border-radius: 16px; 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 0.8rem 1.5rem;
            z-index: 1040; 
        }

        /* --- GAYA SIDEBAR --- */
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100; 
            padding: 100px 0 0; 
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .05);
            background-color: #ffffff;
            transition: all 0.3s;
        }
        
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 100px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Menu Link Styling */
        .nav-link {
            font-weight: 500;
            color: #64748b; 
            padding: 10px 20px;
            margin: 2px 15px;
            border-radius: 10px;
            transition: all 0.2s;
        }
        
        .nav-link:hover {
            color: #0d6efd;
            background-color: #f1f5f9;
        }
        
        .nav-link.active {
            color: #0d6efd;
            background-color: #eff6ff;
            font-weight: 700;
            box-shadow: 0 2px 5px rgba(13, 110, 253, 0.1);
        }

        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            color: #94a3b8;
        }

        /* --- CONTENT ADJUSTMENT --- */
        .main-content {
            margin-left: 240px; 
            padding-top: 110px; 
            padding-right: 15px;
            padding-left: 15px;
            transition: all 0.3s;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 767.98px) {
            .sidebar {
                top: 85px; 
                padding-top: 0;
                z-index: 1050; 
            }
            .main-content { margin-left: 0; padding-top: 120px; }
            .navbar-floating { left: 10px; right: 10px; top: 10px; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-light fixed-top navbar-floating">
    <div class="container-fluid px-0">
        
        <button class="navbar-toggler border-0 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="#">
            <i class="fas fa-landmark fa-lg me-2"></i>
            <span>SIDOKERTO<span class="text-dark">APP</span></span>
        </a>

        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark fw-bold d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2 shadow-sm" style="width: 35px; height: 35px;">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-3 mt-2" aria-labelledby="userDropdown">
                    <li><span class="dropdown-item-text text-muted small">Role: {{ ucfirst(Auth::user()->role) }}</span></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    
                    @if(Auth::user()->role == 'admin')
                        <h6 class="sidebar-heading px-3 mt-2 mb-2">Administrator</h6>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.biodata.*') ? 'active' : '' }}" href="{{ route('admin.biodata.index') }}">
                                <i class="fas fa-users fa-fw me-2"></i> Data Penduduk
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.berita.*') ? 'active' : '' }}" href="{{ route('admin.berita.index') }}">
                                <i class="fas fa-newspaper fa-fw me-2"></i> Berita Desa
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.surat.*') ? 'active' : '' }}" href="{{ route('admin.surat.index') }}">
                                <i class="fas fa-envelope-open-text fa-fw me-2"></i> Surat Masuk
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.pengaduan.*') ? 'active' : '' }}" href="{{ route('admin.pengaduan.index') }}">
                                <i class="fas fa-bullhorn fa-fw me-2"></i> Pengaduan
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.keuangan.*') ? 'active' : '' }}" href="{{ route('admin.keuangan.index') }}">
                                <i class="fas fa-money-bill-wave fa-fw me-2"></i> Keuangan Desa
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.log.*') ? 'active' : '' }}" href="{{ route('admin.log.index') }}">
                                <i class="fas fa-history fa-fw me-2"></i> Log Aktivitas
                            </a>
                        </li>

                    @elseif(Auth::user()->role == 'warga')
                        <h6 class="sidebar-heading px-3 mt-2 mb-2">Layanan Mandiri</h6>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('warga.dashboard') ? 'active' : '' }}" href="{{ route('warga.dashboard') }}">
                                <i class="fas fa-home fa-fw me-2"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('warga.profil') ? 'active' : '' }}" href="{{ route('warga.profil') }}">
                                <i class="fas fa-user-circle fa-fw me-2"></i> Profil Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('surat.*') ? 'active' : '' }}" href="{{ route('surat.index') }}">
                                <i class="fas fa-envelope fa-fw me-2"></i> Surat Menyurat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('pengaduan.*') ? 'active' : '' }}" href="{{ route('pengaduan.index') }}">
                                <i class="fas fa-comment-dots fa-fw me-2"></i> Pengaduan
                            </a>
                        </li>
                    @endif
                </ul>

                <h6 class="sidebar-heading px-3 mt-4 mb-2">Pintasan</h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="{{ url('/') }}">
                            <i class="fas fa-globe fa-fw me-2"></i> Web Desa
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 main-content">
            <div class="fade-in-up">
                @yield('content')
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<style>
    .fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</body>
</html>