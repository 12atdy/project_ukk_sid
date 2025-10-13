<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Desa Sidokerto</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Hero Section Styling */
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url({{asset('images/gambar-desa.jpg')}});
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
        }
        
        .hero-section h1 {
            font-weight: 700;
            font-size: 3.5rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }

        .hero-section p {
            font-size: 1.25rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        }

        /* Feature Section Styling */
        .feature-icon {
            font-size: 3rem;
            color: #0d6efd;
        }
        
        .card-feature {
            border: 0;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.1);
            transition: transform .2s;
        }
        .card-feature:hover {
            transform: translateY(-10px);
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
                <img src="{{ asset('images/logo-sidokerto.png') }}" alt="Logo Desa Sidokerto" height="30" class="me-2">

                <span>Desa Sidokerto</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white ms-lg-2 px-3" href="{{ route('biodata.index') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Login Aparatur
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="container" data-aos="fade-up">
            <h1 class="display-4">Selamat Datang di Website Desa Sidokerto</h1>
            <p class="lead my-4">Transparansi dan Pelayanan Publik Berbasis Digital untuk Kesejahteraan Bersama.</p>
            <a href="#fitur" class="btn btn-primary btn-lg px-4">Jelajahi Fitur</a>
        </div>
    </header>
    
    <section id="fitur" class="py-5">
        <div class="container">
            <div class="row text-center mb-5" data-aos="fade-up">
                <div class="col">
                    <h2>Layanan Unggulan Kami</h2>
                    <p class="lead text-muted">Akses informasi dan layanan desa dengan mudah.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card card-feature text-center p-4 h-100">
                        <div class="feature-icon mb-3"><i class="fas fa-newspaper"></i></div>
                        <h4 class="card-title">Berita Desa Terkini</h4>
                        <p class="card-text">Dapatkan informasi dan pengumuman terbaru langsung dari pemerintahan desa.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card card-feature text-center p-4 h-100">
                        <div class="feature-icon mb-3"><i class="fas fa-file-alt"></i></div>
                        <h4 class="card-title">Layanan Surat Online</h4>
                        <p class="card-text">Ajukan permohonan surat keterangan dan dokumen lainnya secara online.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card card-feature text-center p-4 h-100">
                        <div class="feature-icon mb-3"><i class="fas fa-chart-line"></i></div>
                        <h4 class="card-title">Data Desa Transparan</h4>
                        <p class="card-text">Lihat data kependudukan, anggaran, dan informasi publik lainnya secara terbuka.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; 2025 Desa Sidokerto. Dibuat dengan ❤️ untuk pelayanan yang lebih baik.</p>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000, // Durasi animasi dalam milidetik
        });
    </script>
</body>
</html>