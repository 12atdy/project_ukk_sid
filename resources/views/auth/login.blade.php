<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Desa Sidokerto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style> body { background-color: #f0f2f5; } </style>
</head>
<body>
<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-5">
                <h3 class="text-center mb-4">Login</h3>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        Email atau password salah.
                    </div>
                @endif
                
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                
                <div class="text-center mt-3">
                    <p class="mb-2 fw-bold text-muted">Belum punya akun?</p>
                    
                    <a href="{{ route('warga.register') }}" class="btn btn-outline-success w-100">
                        <i class="fas fa-user-plus me-1"></i> Daftar Akun
                    </a>
                    
                    <div class="mt-3">
                        <a href="{{ url('/') }}" class="text-decoration-none small text-secondary">
                            &larr; Kembali ke Halaman Depan
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>