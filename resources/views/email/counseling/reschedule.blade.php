<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Reschedule Konseling</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #007bff; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
        <h2 style="margin: 0; font-size: 24px;">📅 Notifikasi {{ ($old_scheduled_at && $old_scheduled_at != 'Belum dijadwalkan') ? 'Reschedule' : 'Jadwal Baru' }} Konseling</h2>
    </div>
    
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 0 0 5px 5px;">
        <p style="margin: 0 0 15px 0;">Halo,</p>
        
        <p style="margin: 0 0 20px 0;">Ada pengajuan {{ ($old_scheduled_at && $old_scheduled_at != 'Belum dijadwalkan') ? 'penjadwalan ulang' : 'jadwal baru' }} konseling yang memerlukan perhatian Anda.</p>
        
        <div style="background-color: white; border: 1px solid #dee2e6; border-radius: 5px; padding: 15px; margin: 15px 0;">
            <div style="font-weight: bold; color: #495057; margin-bottom: 5px;">Nama Pengaju:</div>
            <div style="color: #212529; margin-bottom: 15px;">{{ $name }}</div>
            
            <div style="font-weight: bold; color: #495057; margin-bottom: 5px;">Judul Konseling:</div>
            <div style="color: #212529; margin-bottom: 15px;">{{ $title }}</div>
            
            @if($old_scheduled_at && $old_scheduled_at != 'Belum dijadwalkan')
            <div style="font-weight: bold; color: #495057; margin-bottom: 5px;">Jadwal Sebelumnya:</div>
            <div style="color: #212529; margin-bottom: 15px;">{{ $old_scheduled_at }}</div>
            @endif
            
            <div style="font-weight: bold; color: #495057; margin-bottom: 5px;">Jadwal Baru:</div>
            <div style="color: #212529; margin-bottom: 15px;">{{ $new_scheduled_at }}</div>
            
            @if($reschedule_reason)
            <div style="font-weight: bold; color: #495057; margin-bottom: 5px;">Alasan Reschedule:</div>
            <div style="color: #212529; margin-bottom: 15px;">{{ $reschedule_reason }}</div>
            @endif
        </div>
        
        <p style="margin: 20px 0;">Silakan tinjau permintaan {{ ($old_scheduled_at && $old_scheduled_at != 'Belum dijadwalkan') ? 'reschedule' : 'jadwal baru' }} ini dan berikan respons yang sesuai.</p>
        
        <div style="text-align: center; margin: 25px 0;">
            <a href="{{ $url }}" style="display: inline-block; padding: 12px 24px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">Lihat Detail Konseling</a>
        </div>
        
        <div style="text-align: center; margin-top: 30px; color: #6c757d; font-size: 14px; border-top: 1px solid #dee2e6; padding-top: 20px;">
            <p style="margin: 5px 0;">Email ini dikirim secara otomatis oleh sistem.</p>
            <p style="margin: 5px 0;">Jika Anda memiliki pertanyaan, silakan hubungi tim support.</p>
        </div>
    </div>
</body>
</html>