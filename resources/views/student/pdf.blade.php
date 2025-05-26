<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Data Siswa</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 20px;
            margin: 0;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            vertical-align: top;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .signature-section {
            margin-top: 60px;
            width: 100%;
        }
        .signature-section td {
            border: none;
            padding-top: 20px;
        }
        .signature-box {
            text-align: center;
        }
        .printed-info {
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Detail Data Siswa</h1>
    </div>

    <div class="section-title">Data Siswa</div>
    <table>
        <tr><th>NISN</th><td>{{ $student->student->nisn }}</td></tr>
        <tr><th>Nama</th><td>{{ $student->name }}</td></tr>
        <tr><th>Email</th><td>{{ $student->email }}</td></tr>
        <tr><th>No Telepon</th><td>{{ $student->phone ?? '-' }}</td></tr>
        <tr><th>Kelas</th><td>{{ $student->student->class }}</td></tr>
        <tr><th>Jenis Kelamin</th><td>{{ $student->student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
        <tr><th>Tempat Lahir</th><td>{{ $student->student->birthplace ?? '-' }}</td></tr>
        <tr><th>Tanggal Lahir</th><td>{{ $student->student->birthdate ? date('d F Y', strtotime($student->student->birthdate)) : '-' }}</td></tr>
        <tr><th>Alamat</th><td>{{ $student->address ?? '-' }}</td></tr>
    </table>

    <div class="section-title">Data Wali</div>
    <table>
        <tr><th>Nama</th><td>{{ optional($student->student->studentParent)->user->name ?? 'N/A' }}</td></tr>
        <tr><th>Email</th><td>{{ optional($student->student->studentParent)->user->email ?? 'N/A' }}</td></tr>
        <tr><th>No Telepon</th><td>{{ optional($student->student->studentParent)->user->phone ?? '-' }}</td></tr>
        <tr><th>Hubungan</th><td>{{ optional($student->student->studentParent)->family_relation ?? 'N/A' }}</td></tr>
        <tr><th>Alamat</th><td>{{ optional($student->student->studentParent)->user->address ?? '-' }}</td></tr>
    </table>

    <div class="section-title">Prestasi Siswa</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Nama Prestasi</th>
                <th style="width: 20%;">Kategori</th>
                <th style="width: 20%;">Tanggal</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @forelse($student->student->achievements as $index => $achievement)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $achievement->name }}</td>
                <td>{{ $achievement->category }}</td>
                <td>{{ date('d F Y', strtotime($achievement->date)) }}</td>
                <td>{{ $achievement->detail }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;">Tidak ada data prestasi</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="section-title">Pelanggaran Siswa</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 25%;">Nama Pelanggaran</th>
                <th style="width: 20%;">Kategori</th>
                <th style="width: 20%;">Tanggal</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
            @forelse($student->student->misconducts as $index => $misconduct)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $misconduct->name }}</td>
                <td>{{ $misconduct->category }}</td>
                <td>{{ date('d F Y', strtotime($misconduct->date)) }}</td>
                <td>{{ $misconduct->detail }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;">Tidak ada data pelanggaran</td></tr>
            @endforelse
        </tbody>
    </table>

    <table class="signature-section">
        <tr>
            <td style="width: 60%;" class="printed-info">
                Dicetak oleh:<br>
                <strong>{{ $user->name }}</strong><br>
                <small>{{ date('d F Y') }}</small><br>
                <small>{{ ucfirst($user->getRoleNames()->first() ?? 'Pengguna') }}</small>
            </td>
            <td style="width: 40%;">
                <div class="signature-box">
                    Hormat Kami,<br><br><br><br>
                    <u>__________________________</u><br>
                    Tanda Tangan
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
