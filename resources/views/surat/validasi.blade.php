<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Surat - Desa Sidokerto</title>
    
    {{-- Kita pakai Bootstrap biar responsif di HP & Laptop --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-verifikasi {
            border: none;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }
        .header-verifikasi {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
            position: relative;
        }
        .logo-desa {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            padding: 5px;
            margin-bottom: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .status-badge {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: bold;
            display: inline-flex;
            align-items: center;
            margin-top: -25px;
            border: 4px solid #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .status-icon {
            font-size: 1.2rem;
            margin-right: 8px;
        }
        .detail-item {
            padding: 12px 0;
            border-bottom: 1px dashed #e0e0e0;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
        .detail-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 2px;
        }
        .detail-value {
            font-weight: 600;
            color: #212529;
            font-size: 1.05rem;
        }
        .footer-verifikasi {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 0.8rem;
            color: #6c757d;
        }
    </style>
</head>
<body>

    <div class="container p-3">
        @if($surat)
            <div class="card card-verifikasi mx-auto">
                <div class="header-verifikasi">
                    {{-- Logo Desa --}}
                    <img src="{{ asset('images/logo-sidokerto.png') }}" alt="Logo" class="logo-desa">
                    <h5 class="mb-0 fw-bold">PEMERINTAH DESA SIDOKERTO</h5>
                    <small class="opacity-75">Sistem Verifikasi Dokumen Digital</small>
                </div>
                
                <div class="card-body text-center pt-0">
                    {{-- Badge Status --}}
                    <div class="status-badge">
                        <i class="fas fa-check-circle status-icon"></i>
                        DOKUMEN ASLI / VALID
                    </div>

                    <div class="mt-4 text-start px-3">
                        <div class="detail-item">
                            <div class="detail-label">Jenis Dokumen</div>
                            <div class="detail-value text-primary">
                                {{ strtoupper(str_replace('_', ' ', $surat->jenis_surat)) }}
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Nomor Surat</div>
                            <div class="detail-value">{{ $surat->nomor_surat }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Tanggal Terbit</div>
                            <div class="detail-value">
                                {{ \Carbon\Carbon::parse($surat->created_at)->translatedFormat('l, d F Y - H:i') }} WIB
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Nama Pemohon</div>
                            <div class="detail-value">{{ $surat->user->name }}</div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Ditandatangani Oleh</div>
                            <div class="detail-value">Kepala Desa Sidokerto</div>
                        </div>
                    </div>

                    <div class="mt-4 mb-2">
                        <a href="{{ url('/') }}" class="btn btn-outline-primary rounded-pill px-4">
                            <i class="fas fa-home me-2"></i> Ke Halaman Utama
                        </a>
                    </div>
                </div>

                <div class="footer-verifikasi">
                    <i class="fas fa-shield-alt me-1"></i>
                    Dokumen ini telah diverifikasi secara elektronik oleh sistem database Desa Sidokerto.
                </div>
            </div>

        @else
            <div class="card card-verifikasi mx-auto border-danger">
                <div class="header-verifikasi bg-danger">
                    <i class="fas fa-exclamation-triangle fa-3x text-white mb-3"></i>
                    <h4 class="mb-0 fw-bold">DOKUMEN TIDAK VALID!</h4>
                    <small class="text-white-50">Data tidak ditemukan di sistem kami.</small>
                </div>
                <div class="card-body text-center p-5">
                    <p class="text-muted mb-4">
                        Maaf, Kode QR yang Anda pindai tidak terdaftar dalam database resmi Pemerintah Desa Sidokerto. 
                        Kemungkinan dokumen ini <strong>PALSU</strong> atau telah dihapus.
                    </p>
                    <a href="{{ url('/') }}" class="btn btn-danger rounded-pill px-4">
                        <i class="fas fa-arrow-left me-2"></i> Kembali
                    </a>
                </div>
            </div>
        @endif
    </div>

</body>
</html>