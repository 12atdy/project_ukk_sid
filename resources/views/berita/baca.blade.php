<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $berita->judul }} - Desa Sidokerto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .hero-img { width: 100%; height: 400px; object-fit: cover; border-radius: 15px; }
        .news-content { font-size: 1.1rem; line-height: 1.8; color: #333; }
        .sidebar-img { width: 80px; height: 60px; object-fit: cover; border-radius: 8px; }
        a { text-decoration: none; }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row">
            
            <!-- KONTEN UTAMA -->
            <div class="col-lg-8">
                <!-- Judul & Meta -->
                <h1 class="fw-bold mb-3">{{ $berita->judul }}</h1>
                <div class="text-muted mb-4 small">
                    <i class="far fa-calendar-alt me-2"></i> {{ $berita->created_at->translatedFormat('l, d F Y') }}
                    <span class="mx-2">|</span>
                    <i class="far fa-user me-2"></i> Ditulis oleh: {{ $berita->user->name }}
                </div>

                <!-- Gambar Utama -->
               <img src="{{ asset('storage/berita/' . $berita->gambar) }}" class="img-fluid rounded mb-4" style="width: 100%; max-height: 500px; object-fit: cover;">

                <!-- Isi Berita -->
                <div class="news-content bg-white p-4 rounded shadow-sm">
                    <!-- nl2br e() supaya enter/paragraf terbaca -->
                    {!! nl2br(e($berita->isi)) !!}
                </div>
            </div>

            <!-- SIDEBAR -->
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top: 90px;">
                    <div class="card-header bg-white fw-bold py-3">
                        <i class="fas fa-newspaper me-2 text-primary"></i> Berita Lainnya
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            @foreach($beritaLain as $item)
                            <li class="list-group-item p-3">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/berita/' . $item->gambar) }}" class="sidebar-img flex-shrink-0">
                                    <div class="ms-3">
                                        <a href="{{ route('berita.baca', $item->id) }}" class="fw-bold text-dark small stretched-link">
                                            {{ Str::limit($item->judul, 45) }}
                                        </a>
                                        <div class="text-muted" style="font-size: 0.75rem; margin-top: 3px;">
                                            {{ $item->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center small">
            &copy; {{ date('Y') }} Pemerintah Desa Sidokerto.
        </div>
    </footer>

</body>
</html>