<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0 auto; padding: 20px; max-width: 600px;">
    <div style="background-color: #fff; border-radius: 8px; border: 2px solid #c0c0c0; border-radius: 8px; padding: 30px; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3); border-bottom: 8px solid #5A6C57;">
        <div style="text-align: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
            <h1 style="color: #2c3e50; font-size: 24px; margin: 0; padding: 0;">
                Pembuatan Akun
            </h1>
        </div>
        <div style="font-size: 16px; color: #555555; margin: 20px 0; padding: 0 10px; text-align: center;">
            <p>Pembuatan akun baru <strong>{{ $contents['name'] }}</strong> telah berhasil.</p>
            <p>Silakan login menggunakan kata sandi berikut:</p>
            <div style="background-color: #f8f9fa; border: 1px solid #e9ecef; border-radius: 4px; padding: 15px; margin: 15px 0; text-align: center; font-family: monospace; font-size: 18px; letter-spacing: 1px;">
                {{ $contents['password'] }}
            </div>
            <div style="text-align: center; margin: 25px 0;">
                <a
                    href="{{ $contents['url'] }}"
                    style="display: inline-block; padding: 10px 30px; background-color: #fff; border: 1px solid #5A6C57; color: #5A6C57; text-decoration: none; border-radius: 1.5rem; font-weight: bold; text-align: center;">
                    Login Sekarang
                </a>
            </div>
            <p style="margin-top: 20px; color: #dc3545;"><strong>Penting:</strong> Mohon segera ubah kata sandi Anda setelah login untuk keamanan akun.</p>
        </div>
        <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0; text-align: center; font-size: 14px; color: #888888;">
            <p>© {{ date('Y') }} Management BK. All rights reserved.</p>
        </div>
    </div>
</body>
</html>