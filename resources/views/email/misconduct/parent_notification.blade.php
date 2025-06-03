<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Pelanggaran Siswa</title>
    <!-- Inline styles applied below -->
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; margin: 0 auto; padding: 20px; max-width: 600px;">
    <div style="background-color: #fff; border-radius: 8px; border: 2px solid #c0c0c0; border-radius: 8px; padding: 30px; box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3); border-bottom: 8px solid #5A6C57;">
        <div style="text-align: center; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
            <h1 style="color: #2c3e50; font-size: 24px; margin: 0; padding: 0;">Pemberitahuan Pelanggaran Siswa</h1>
        </div>
        <div class="content" style="padding: 0 20px 20px 20px;">
            <p>Yth. Bapak/Ibu {{ $contents['parent_name'] }},</p>

            <p>Dengan ini kami memberitahukan bahwa siswa/i Anda dengan detail:</p>

            <div class="detail-item" style="margin-bottom: 10px;"><strong style="display: inline-block; width: 80px;">Nama:</strong> {{ $contents['student_name'] }}</div>
            <div class="detail-item" style="margin-bottom: 10px;"><strong style="display: inline-block; width: 80px;">Kelas:</strong> {{ $contents['student_class'] }}</div>
            <div class="detail-item" style="margin-bottom: 10px;"><strong style="display: inline-block; width: 80px;">NISN:</strong> {{ $contents['student_nisn'] }}</div>

            <p>telah melakukan pelanggaran <strong style="font-weight: bold;">{{ $contents['misconduct_name'] }}</strong> pada tanggal {{ $contents['misconduct_date'] }}.</p>

            <p>Mohon perhatian Bapak/Ibu terkait hal ini. Untuk melihat detail pelanggaran lebih lanjut, silakan klik tombol di bawah:</p>

            <div style="text-align: center; margin: 25px 0;">
                <a href="{{ $contents['detail_url'] }}" style="display: inline-block; padding: 10px 30px; background-color: #fff; color: #dc3545; border: 1px solid #dc3545; text-decoration: none; border-radius: 1.5rem; font-weight: bold;">Lihat Detail</a>
            </div>

            <p>Terima kasih atas perhatian dan kerja sama Bapak/Ibu.</p>

            <p>Hormat kami,</p>
            <p>Tim Guru BK</p>
        </div>
        <div class="footer" style="text-align: center; margin-top: 20px; font-size: 12px; color: #777;">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 