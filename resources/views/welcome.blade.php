<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Sidokerto - Pelayanan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset("images/gambar-desa.jpg") }}');
            background-size: cover;
            background-position: center;
            height: 80vh;
            display: flex;
            align-items: center;
            color: white;
        }
        .card-berita:hover { transform: translateY(-5px); transition: 0.3s; }
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-landmark me-2"></i> DESA SIDOKERTO</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>
                    <li class="nav-item"><a class="nav-link" href="#kontak">Kontak</a></li>
                    <li class="nav-item ms-lg-3">
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm px-4 rounded-pill">
                            <i class="fas fa-sign-in-alt me-2"></i> Masuk / Daftar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section text-center">
        <div class="container">
            <h1 class="display-3 fw-bold mb-3">Selamat Datang di Desa Sidokerto</h1>
            <p class="lead mb-4">Wujudkan pelayanan publik yang transparan, cepat, dan efisien melalui Sistem Informasi Desa Digital.</p>
            <a href="{{ route('login') }}" class="btn btn-success btn-lg px-5 shadow">
                <i class="fas fa-envelope-open-text me-2"></i> Ajukan Surat Online
            </a>
        </div>
    </header>

    <section id="berita" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-dark">Kabar Desa Terkini</h2>
                <div class="bg-primary mx-auto" style="width: 60px; height: 3px;"></div>
            </div>

            <div class="row">
                @forelse($beritaTerbaru as $item)
                <div class="col-md-4 mb-4">
                    <div class="card card-berita h-100 border-0 shadow-sm">
                        <img src="{{ asset('storage/berita/' . $item->gambar) }}" class="card-img-top" alt="Gambar Berita" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ $item->created_at->format('d M Y') }}</small>
                            <h5 class="card-title mt-2 fw-bold">{{ Str::limit($item->judul, 50) }}</h5>
                            <p class="card-text text-secondary small">{{ Str::limit($item->isi, 100) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">Belum ada berita terbaru.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <footer id="kontak" class="bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="fw-bold">Tentang Kami</h5>
                    <p class="small text-muted">Sistem Informasi Desa Sidokerto adalah platform digital untuk memudahkan administrasi dan pelayanan kepada masyarakat.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5 class="fw-bold">Hubungi Kami</h5>
                    <p class="small mb-1"><i class="fas fa-map-marker-alt me-2"></i> Jl. Raya Sidokerto No. 1, Sidoarjo</p>
                    <p class="small mb-1"><i class="fas fa-envelope me-2"></i> admin@desasidokerto.id</p>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center small text-muted">
                &copy; {{ date('Y') }} Pemerintah Desa Sidokerto. All Rights Reserved.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>