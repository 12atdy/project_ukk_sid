<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Sidokerto - Pelayanan Digital</title>
    
    <!-- Bootstrap 5 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        
        /* NAVBAR TRANSPARAN */
        .navbar { transition: all 0.3s; padding: 1rem 0; }
        .navbar-scrolled { background-color: white; box-shadow: 0 4px 20px rgba(0,0,0,0.05); padding: 0.5rem 0; }
        .navbar-brand { font-weight: 800; letter-spacing: -0.5px; font-size: 1.5rem; }
        
        /* HERO SECTION */
        .hero-section {
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.9), rgba(13, 253, 185, 0.8)), url('{{ asset("images/gambar-desa.jpg") }}');
            background-size: cover;
            background-position: center;
            min-height: 85vh;
            color: white;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0 100%);
        }

        /* SERVICES CARD (BISA DIKLIK) */
        .service-link { text-decoration: none; color: inherit; display: block; height: 100%; }
        .service-card {
            border: none;
            border-radius: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
            background: white;
            padding: 2rem;
            height: 100%;
            cursor: pointer; /* Menandakan bisa diklik */
        }
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            background-color: #f8fcff; /* Sedikit biru saat dihover */
        }
        .icon-box {
            width: 80px; height: 80px;
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem; margin-bottom: 1.5rem;
            transition: 0.3s;
        }
        .service-card:hover .icon-box {
            transform: scale(1.1); /* Icon membesar dikit pas hover */
        }

        /* BERITA CARD */
        .card-berita {
            border: none; border-radius: 15px; overflow: hidden;
            transition: 0.3s; height: 100%;
        }
        .card-berita:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.08); }
        .card-berita img { height: 200px; object-fit: cover; }
        .berita-date {
            background: #0d6efd; color: white;
            padding: 5px 15px; border-radius: 50px;
            font-size: 0.75rem; position: absolute; top: 15px; right: 15px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-leaf me-2"></i> SIDOKERTO</a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-lg-3">
                    <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>
                    <li class="nav-item ms-lg-2">
                        @auth
                            @if(Auth::user()->role == 'admin')
                                <a href="{{ route('dashboard') }}" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm">Dashboard Admin</a>
                            @else
                                <a href="{{ route('warga.dashboard') }}" class="btn btn-light text-primary fw-bold rounded-pill px-4 shadow-sm">Dashboard Warga</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4 me-2">Masuk</a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO HEADER -->
    <header class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill"><i class="fas fa-star me-1"></i> Pelayanan Desa Digital</span>
                    <h1 class="display-3 fw-bold mb-4">Sistem Informasi Desa Sidokerto</h1>
                    <p class="lead mb-5 opacity-90">Nikmati kemudahan mengurus administrasi surat, pelaporan masalah, dan akses informasi desa terbaru secara online, cepat, dan transparan.</p>
                    <div class="d-flex gap-3">
                        @auth
                            <a href="{{ route('warga.dashboard') }}" class="btn btn-light btn-lg text-primary fw-bold rounded-pill px-5 shadow">
                                Ke Dashboard <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-light btn-lg text-primary fw-bold rounded-pill px-5 shadow">
                                Mulai Sekarang <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        @endauth
                        <a href="#layanan" class="btn btn-outline-light btn-lg rounded-pill px-4">Pelajari Lebih</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- LAYANAN KAMI (Card Bisa Diklik) -->
    <section id="layanan" class="py-5" style="margin-top: -50px;">
        <div class="container">
            <div class="row justify-content-center g-4">
                
                <!-- Card 1: Surat Online (Link ke Dashboard/Login) -->
                <div class="col-md-4">
                    <a href="{{ Auth::check() ? route('surat.index') : route('login') }}" class="service-link">
                        <div class="service-card shadow">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <h4 class="fw-bold text-dark">Surat Online</h4>
                            <p class="text-muted">Ajukan surat pengantar nikah, usaha, domisili, dan lainnya dari rumah. Hemat waktu tanpa antre.</p>
                            <span class="text-primary fw-bold small">Akses Layanan &rarr;</span>
                        </div>
                    </a>
                </div>

                <!-- Card 2: Layanan Pengaduan (Link ke Pengaduan) -->
                <div class="col-md-4">
                    <a href="{{ Auth::check() ? route('pengaduan.index') : route('login') }}" class="service-link">
                        <div class="service-card shadow">
                            <div class="icon-box bg-danger bg-opacity-10 text-danger">
                                <i class="fas fa-bullhorn"></i>
                            </div>
                            <h4 class="fw-bold text-dark">Layanan Pengaduan</h4>
                            <p class="text-muted">Laporkan masalah lingkungan atau fasilitas desa. Pantau respon dan penyelesaiannya secara realtime.</p>
                            <span class="text-danger fw-bold small">Buat Laporan &rarr;</span>
                        </div>
                    </a>
                </div>

                <!-- Card 3: Berita Desa (Link Scroll ke Bawah) -->
                <div class="col-md-4">
                    <a href="#berita" class="service-link">
                        <div class="service-card shadow">
                            <div class="icon-box bg-success bg-opacity-10 text-success">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h4 class="fw-bold text-dark">Berita Desa</h4>
                            <p class="text-muted">Dapatkan informasi terbaru seputar kegiatan, pengumuman, dan transparansi anggaran desa.</p>
                            <span class="text-success fw-bold small">Baca Berita &rarr;</span>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- BERITA TERKINI -->
    <section id="berita" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase letter-spacing-2">Update Terbaru</h6>
                <h2 class="fw-bold display-6">Kabar Desa Sidokerto</h2>
            </div>

            <div class="row g-4">
                @forelse($beritaTerbaru as $item)
                <div class="col-lg-4 col-md-6">
                    <div class="card card-berita shadow-sm h-100">
                        <div class="position-relative">
                            <img src="{{ asset('storage/berita/' . $item->gambar) }}" class="card-img-top" alt="Berita">
                            <span class="berita-date shadow-sm">{{ $item->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="card-title fw-bold mb-3">
                                <a href="{{ route('berita.baca', $item->id) }}" class="text-dark text-decoration-none stretched-link">{{ Str::limit($item->judul, 50) }}</a>
                            </h5>
                            <p class="card-text text-muted small">{{ Str::limit($item->isi, 100) }}</p>
                        </div>
                        <div class="card-footer bg-white border-0 px-4 pb-4 pt-0">
                            <small class="text-primary fw-bold">Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i></small>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="alert alert-light border shadow-sm d-inline-block px-5">
                        <i class="fas fa-newspaper fa-2x text-muted mb-3"></i>
                        <p class="text-muted mb-0">Belum ada berita yang dipublikasikan.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- SAMBUTAN KADES -->
    <section class="py-5 bg-white border-top">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0 text-center">
                    <!-- Placeholder Foto Kades -->
                    <div class="bg-light rounded-circle mx-auto d-flex align-items-center justify-content-center shadow" style="width: 300px; height: 300px; overflow: hidden; border: 5px solid white;">
                        <i class="fas fa-user-tie fa-8x text-secondary opacity-25"></i>
                    </div>
                </div>
                <div class="col-lg-7">
                    <h3 class="fw-bold mb-3">Sambutan Kepala Desa</h3>
                    <p class="text-muted leading-relaxed">
                        "Selamat datang di website resmi Desa Sidokerto. Transformasi digital ini adalah wujud komitmen kami untuk memberikan pelayanan terbaik, transparan, dan akuntabel bagi seluruh warga. Mari bersama-sama membangun desa kita menjadi lebih maju, mandiri, dan sejahtera."
                    </p>
                    <h5 class="fw-bold mt-4">Bpk. Kepala Desa</h5>
                    <small class="text-muted">Kepala Desa Sidokerto Periode 2024-2029</small>
                    
                    <div class="mt-4">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e1/Logo_of_the_Ministry_of_Home_Affairs_of_the_Republic_of_Indonesia.svg/600px-Logo_of_the_Ministry_of_Home_Affairs_of_the_Republic_of_Indonesia.svg.png" height="40" class="me-3 opacity-50">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-dark text-white pt-5 pb-3">
        <div class="container">
            <div class="row g-4 mb-4">
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3"><i class="fas fa-leaf me-2 text-success"></i> SIDOKERTO</h5>
                    <p class="text-white-50 small">Sistem Informasi Desa terpadu untuk memudahkan administrasi kependudukan dan pelayanan publik secara digital.</p>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3">Kontak Kami</h5>
                    <ul class="list-unstyled text-white-50 small">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Jl. Raya Sidokerto No. 1, Sidoarjo</li>
                        <li class="mb-2"><i class="fas fa-phone me-2 text-primary"></i> (031) 123-4567</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> admin@desasidokerto.id</li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold mb-3">Jam Pelayanan</h5>
                    <ul class="list-unstyled text-white-50 small">
                        <li class="d-flex justify-content-between border-bottom border-secondary pb-2 mb-2">
                            <span>Senin - Kamis</span> <span>08:00 - 15:00</span>
                        </li>
                        <li class="d-flex justify-content-between border-bottom border-secondary pb-2 mb-2">
                            <span>Jumat</span> <span>08:00 - 11:00</span>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span>Sabtu - Minggu</span> <span>Libur</span>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center text-white-50 small">
                &copy; {{ date('Y') }} Pemerintah Desa Sidokerto. All Rights Reserved.
            </div>
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const navbar = document.getElementById('mainNav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
                navbar.classList.add('navbar-light');
                navbar.classList.remove('navbar-dark');
            } else {
                navbar.classList.remove('navbar-scrolled');
                navbar.classList.remove('navbar-light');
                navbar.classList.add('navbar-dark');
            }
        });
    </script>
</body>
</html>