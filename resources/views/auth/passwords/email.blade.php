<!DOCTYPE html>
<html lang="id">
<head>
    <title>Lupa Password - Desa Sidokerto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <div class="container" style="max-width: 500px">
        <div class="card shadow border-0">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold">Lupa Password?</h3>
                    <p class="text-muted">Masukkan email yang terdaftar, kami akan mengirimkan link untuk mereset password Anda.</p>
                </div>
                
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="contoh@email.com" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 btn-lg">Kirim Link Reset</button>
                    
                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none text-secondary">Kembali ke Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>