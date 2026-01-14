<!DOCTYPE html>
<html lang="id">
<head>
    <title>Verifikasi OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center vh-100">
    <div class="container" style="max-width: 450px">
        <div class="card shadow border-0">
            <div class="card-body p-5 text-center">
                <h3 class="mb-3">Verifikasi Akun</h3>
                <p class="text-muted">Kami telah mengirimkan 6 digit kode ke email <strong>{{ $email }}</strong></p>

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form action="{{ route('verification.verify') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <div class="mb-4">
                        <input type="number" name="otp" class="form-control form-control-lg text-center fw-bold" placeholder="X X X X X X" style="letter-spacing: 5px; font-size: 24px;" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 btn-lg">Verifikasi</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>