<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Pelanggaran Siswa</title>
    <!-- Inline styles applied below -->
</head>
<body style="font-family: 'Plus Jakarta Sans', sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f4f4f4; color: #333;">
    <div class="container" style="max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <div class="header" style="background-color: #5A6C57; color: #ffffff; padding: 10px 0; text-align: center; border-top-left-radius: 8px; border-top-right-radius: 8px; margin-bottom: 20px;">
            <h1 style="margin: 0; font-size: 24px;">Pemberitahuan Pelanggaran Siswa</h1>
        </div>
        <div class="content" style="padding: 0 20px 20px 20px;">
            <p>Yth. Bapak/Ibu {{ $parent_name }},</p>

            <p>Dengan ini kami memberitahukan bahwa siswa/i Anda dengan detail:</p>

            <div class="detail-item" style="margin-bottom: 10px;"><strong style="display: inline-block; width: 80px;">Nama:</strong> {{ $student_name }}</div>
            <div class="detail-item" style="margin-bottom: 10px;"><strong style="display: inline-block; width: 80px;">Kelas:</strong> {{ $student_class }}</div>
            <div class="detail-item" style="margin-bottom: 10px;"><strong style="display: inline-block; width: 80px;">NISN:</strong> {{ $student_nisn }}</div>

            <p>telah melakukan pelanggaran <strong style="font-weight: bold;">{{ $misconduct_name }}</strong> pada tanggal {{ $misconduct_date }}.</p>

            <p>Mohon perhatian Bapak/Ibu terkait hal ini. Untuk melihat detail pelanggaran lebih lanjut, silakan klik tombol di bawah:</p>

            <p style="text-align: center;">
                <a href="{{ $detail_url }}" class="button" style="display: inline-block; background-color: #F9CB43; color: #333 !important; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Lihat Detail Siswa</a>
            </p>

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