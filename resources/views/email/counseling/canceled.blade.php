<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Konseling Dibatalkan</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0 auto; padding: 20px; max-width: 600px;">
    <div style="background-color: #fff; border-radius: 8px; border: 2px solid #c0c0c0; border-radius: 8px; padding: 30px; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3); border-bottom: 8px solid #dc3545;">
        <div style="text-align: center; margin-bottom: 25px;padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
            <h1 style="color: #2c3e50; font-size: 24px; margin: 0; padding: 0;">
                Konseling Dibatalkan
            </h1>
        </div>
        
        <div style="padding: 20px 0; text-align: center;">
            <p>Halo {{ $contents['name'] }},</p>
            
            <p>Mohon maaf, pengajuan konseling Anda dibatalkan. Berikut adalah detail konseling Anda:</p>
            
            <div style="background: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <p><strong>Judul Konseling:</strong> {{ $contents['title'] }}</p>
                <p><strong>Tanggal & Waktu:</strong> {{ $contents['scheduled_at'] }}</p>
                <p><strong>Alasan Pembatalan:</strong></p>
                <p style="color: #dc3545;">{{ $contents['notes'] }}</p>
            </div>

            <p>Jika Anda memiliki pertanyaan atau ingin mengajukan konseling baru, silakan hubungi konselor Anda.</p>
        </div>
        
        <div style="text-align: center; margin-top: 20px; padding-top: 20px; border-top: 1px solid #eee; font-size: 12px; color: #666;">
            <p>Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} Sistem Manajemen Konseling. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 