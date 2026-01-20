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
            background-color: #f4f6f9; /* Warna background lebih soft (AdminLTE style) */
            font-family: 'Inter', sans-serif;
            overflow-x: hidden; /* Mencegah scroll samping */
        }

        /* --- 1. NAVBAR FIXED (NEMPEL DI ATAS) --- */
        .navbar-custom {
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 60px; /* Tinggi tetap biar rapi */
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6; /* Garis pemisah tipis */
            box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
            padding: 0 1rem;
            z-index: 1040;
            display: flex;
            align-items: center;
        }

        /* --- 2. SIDEBAR (Full Height) --- */
        .sidebar {
            position: fixed;
            top: 60px; /* Mundur sesuai tinggi navbar */
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 20px 0 0;
            box-shadow: 1px 0 0 rgba(0, 0, 0, .1);
            background-color: #ffffff;
            transition: all 0.3s;
        }
        
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 60px);
            padding-top: 0.5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Menu Link Styling */
        .nav-link {
            font-weight: 500;
            color: #495057;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            border-radius: 0; /* Hapus radius biar kotak */
            border-left: 4px solid transparent; /* Indikator aktif di kiri */
        }
        
        .nav-link:hover {
            color: #0d6efd;
            background-color: #f8f9fa;
        }
        
        /* Menu Aktif (Indikator Biru di Kiri) */
        .nav-link.active {
            color: #0d6efd;
            background-color: #e9ecef;
            font-weight: 700;
            border-left-color: #0d6efd; 
        }

        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            color: #adb5bd;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        /* --- 3. KONTEN UTAMA --- */
        .main-content {
            margin-left: 240px; 
            padding-top: 80px; /* Jarak aman dari navbar */
            padding-right: 20px;
            padding-left: 20px;
            padding-bottom: 40px;
            transition: all 0.3s;
        }

        /* --- RESPONSIVE (HP) --- */
        @media (max-width: 767.98px) {
            .sidebar {
                top: 60px;
                z-index: 1050; 
                width: 100%; /* Sidebar menutupi layar di HP */
            }
            .main-content { 
                margin-left: 0; 
                padding-top: 80px; 
            }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-light fixed-top navbar-custom">
    <div class="container-fluid px-0">
        
        <button class="navbar-toggler border-0 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="#">
            {{-- LOGO DESA --}}
            <img src="{{ asset('images/logo-sidokerto.png') }}" alt="Logo" height="35" class="me-2">
            
            <span style="font-size: 1.1rem; letter-spacing: -0.5px;">
                SIDOKERTO<span class="text-dark">APP</span>
            </span>
        </a>

        <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark fw-bold d-flex align-items-center p-0" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex flex-column text-end me-2 d-none d-md-block" style="line-height: 1.1;">
                        <span style="font-size: 0.9rem;">{{ Auth::user()->name }}</span>
                        <span class="text-muted" style="font-size: 0.7rem;">{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center border" style="width: 40px; height: 40px;">
                        <i class="fas fa-user"></i>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2" aria-labelledby="userDropdown">
                    <li class="d-md-none text-center py-2 bg-light">
                        <strong>{{ Auth::user()->name }}</strong><br>
                        <small class="text-muted">{{ ucfirst(Auth::user()->role) }}</small>
                    </li>
                    <li><hr class="dropdown-divider d-md-none"></li>
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
                        <h6 class="sidebar-heading px-3">UTAMA</h6>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt fa-fw me-2"></i> Dashboard
                            </a>
                        </li>

                        <h6 class="sidebar-heading px-3">DATA MASTER</h6>

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
                            <a class="nav-link {{ Request::routeIs('admin.keuangan.*') ? 'active' : '' }}" href="{{ route('admin.keuangan.index') }}">
                                <i class="fas fa-wallet fa-fw me-2"></i> Keuangan Desa
                            </a>
                        </li>

                        <h6 class="sidebar-heading px-3">ADMINISTRASI</h6>

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
                            <a class="nav-link {{ Request::routeIs('admin.log.*') ? 'active' : '' }}" href="{{ route('admin.log.index') }}">
                                <i class="fas fa-history fa-fw me-2"></i> Log Aktivitas
                            </a>
                        </li>

                    @elseif(Auth::user()->role == 'warga')
                        <h6 class="sidebar-heading px-3">LAYANAN MANDIRI</h6>
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
                                <i class="fas fa-file-alt fa-fw me-2"></i> Buat Surat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::routeIs('pengaduan.*') ? 'active' : '' }}" href="{{ route('pengaduan.index') }}">
                                <i class="fas fa-comment-dots fa-fw me-2"></i> Lapor/Aduan
                            </a>
                        </li>
                    @endif
                </ul>

                <h6 class="sidebar-heading px-3 mt-4">Pintasan</h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link text-secondary" href="{{ url('/') }}">
                            <i class="fas fa-globe fa-fw me-2"></i> Website Desa
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
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</body>
</html>