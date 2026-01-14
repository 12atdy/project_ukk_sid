<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verifikasi OTP</title>
</head>
<body style="background-color: #f3f4f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px;">

    <div style="max-width: 500px; margin: 0 auto; background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        
        <div style="background-color: #0d6efd; padding: 20px; text-align: center; color: #ffffff;">
            <h2 style="margin: 0; font-weight: bold;">Sistem Informasi Desa</h2>
        </div>

        <div style="padding: 30px; text-align: center;">
            <h3 style="color: #333333; margin-top: 0;">Halo, {{ $user->name }}!</h3>
            <p style="color: #666666; font-size: 16px; line-height: 1.5;">
                Terima kasih telah mendaftar. Untuk menyelesaikan proses pendaftaran, silakan masukkan kode verifikasi berikut:
            </p>

            <div style="margin: 30px 0;">
                <span style="display: inline-block; background-color: #f8f9fa; border: 2px dashed #0d6efd; color: #0d6efd; font-size: 32px; font-weight: bold; padding: 15px 30px; letter-spacing: 5px; border-radius: 8px;">
                    {{ $otp }}
                </span>
            </div>

            <p style="color: #666666; font-size: 14px;">
                Kode ini hanya berlaku selama <strong>10 menit</strong>.<br>
                Jika Anda tidak merasa mendaftar, abaikan email ini.
            </p>
        </div>

        <div style="background-color: #f8f9fa; padding: 15px; text-align: center; font-size: 12px; color: #999999; border-top: 1px solid #eeeeee;">
            &copy; {{ date('Y') }} Pemerintah Desa Sidokerto.<br>
            Jangan berikan kode ini kepada siapa pun.
        </div>
    </div>

</body>
</html>