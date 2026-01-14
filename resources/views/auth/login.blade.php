<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Desa Sidokerto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .login-header {
            background-color: #fff;
            padding: 30px 20px;
            text-align: center;
        }
        .login-body {
            padding: 40px 30px;
            background-color: #f8f9fa;
        }
        .form-control {
            border-radius: 25px;
            padding: 12px 20px;
        }
        .btn-login {
            border-radius: 25px;
            padding: 12px;
            font-weight: bold;
            font-size: 16px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card card-login">
                    <div class="login-header">
                        <!-- Pastikan logo ada, jika tidak, pakai teks saja atau placeholder -->
                        <img src="{{ asset('images/logo-sidokerto.png') }}" alt="Logo Desa" width="80" class="mb-3" onerror="this.style.display='none'">
                        <h4 class="fw-bold text-primary mb-1">Desa Sidokerto</h4>
                        <p class="text-muted small mb-0">Silakan login untuk masuk ke sistem</p>
                    </div>
                    <div class="login-body">
                        
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- FORM LOGIN -->
                        <form action="{{ route('login.post') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-muted ms-2">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-3"><i class="fas fa-envelope text-primary"></i></span>
                                    <input type="email" name="email" class="form-control border-start-0 ps-2" placeholder="contoh@email.com" required autofocus>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted ms-2">Kata Sandi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 rounded-start-pill ps-3"><i class="fas fa-lock text-primary"></i></span>
                                    <input type="password" name="password" class="form-control border-start-0 ps-2" placeholder="Masukkan password" required>
                                </div>
                            </div>

                            <div class="text-end mb-3">
                                <a href="{{ route('password.request') }}" class="text-decoration-none small">Lupa Password?</a>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-login shadow">
                                    MASUK <i class="fas fa-sign-in-alt ms-2"></i>
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="small text-muted mb-2">Belum punya akun warga?</p>
                                <a href="{{ route('warga.register') }}" class="text-decoration-none fw-bold text-primary">
                                    Daftar Akun Baru
                                </a>
                            </div>
                            
                            <div class="text-center mt-3 border-top pt-3">
                                <a href="{{ url('/') }}" class="text-decoration-none small text-secondary">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>