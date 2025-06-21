<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "Times New Roman", serif;
            font-size: 12px;
            color: #000;
            margin: 40px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 4px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .info-table td {
            padding: 6px 4px;
            vertical-align: top;
        }
        .info-table td:first-child {
            width: 25%;
        }
        .info-table td:nth-child(2) {
            width: 5%;
        }
        .info-table td:last-child {
            width: 70%;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #000000;
            padding: 8px;
            vertical-align: top;
        }
        th {
            background-color: #0090ea;
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <div style="width: 100%; display: table; border-bottom: 2px solid black; margin-bottom: 20px; padding-bottom: 10px;">
        <!-- Logo kiri -->
        <div style="display: table-cell; width: 100px; text-align: center; vertical-align: middle;">
            <img src="asset/images/logo-dispendik.png" style="height: 85px;">
        </div>
    
        <!-- Teks tengah -->
        <div style="display: table-cell; text-align: center; vertical-align: middle;">
            <p style="margin: 0; font-size: 11px;">PEMERINTAH KOTA SURABAYA</p>
            <p style="margin: 2px 0; font-size: 16px; font-weight: bold;">SMP NEGERI 22 SURABAYA</p>
            <p style="margin: 2px 0; font-size: 11px;">Jalan Gayungsari Barat X/38 Surabaya 60235</p>
            <p style="margin: 2px 0; font-size: 11px;">Telepon (031) 8290075</p>
            <p style="margin: 2px 0; font-size: 10px;">
                Laman: <a href="https://www.smpn22sby.sch.id/" style="text-decoration: underline; color: #0066cc;">https://www.smpn22sby.sch.id/</a> |
                Posel: <a href="mailto:dapudasurabaya@gmail.com" style="text-decoration: underline; color: #0066cc;">dapudasurabaya@gmail.com</a>
            </p>
        </div>
    
        <!-- Logo kanan -->
        <div style="display: table-cell; width: 100px; text-align: center; vertical-align: middle;">
            <img src="asset/images/dapuda.png" style="height: 85px;">
        </div>
    </div>
    
    
    <div style="text-align: center; margin-bottom: 15px;">
        <h2 style="margin: 0; font-size: 16px; font-weight: bold; text-transform: uppercase;">Detail Siswa</h2>

    </div>

    <div class="section-title">Data Siswa</div>

    <table class="info-table">
        <tr><td>NISN</td><td>:</td><td>{{ $student->student->nisn }}</td></tr>
        <tr><td>Nama</td><td>:</td><td>{{ $student->name }}</td></tr>
        <tr><td>Email</td><td>:</td><td>{{ $student->email }}</td></tr>
        <tr><td>No Telepon</td><td>:</td><td>{{ $student->phone ?? '-' }}</td></tr>
        <tr><td>Kelas</td><td>:</td><td>{{ $student->student->class }}</td></tr>
        <tr><td>Jenis Kelamin</td><td>:</td><td>{{ $student->student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td></tr>
        <tr><td>Tempat Lahir</td><td>:</td><td>{{ $student->student->birthplace ?? '-' }}</td></tr>
        <tr><td>Tanggal Lahir</td><td>:</td><td>{{ $student->student->birthdate ? date('d F Y', strtotime($student->student->birthdate)) : '-' }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td>{{ $student->address ?? '-' }}</td></tr>
    </table>

    <div class="section-title">Data Wali</div>
    <table class="info-table">
        <tr><td>Nama</td><td>:</td><td>{{ optional($student->student->studentParent)->user->name ?? 'N/A' }}</td></tr>
        <tr><td>Email</td><td>:</td><td>{{ optional($student->student->studentParent)->user->email ?? 'N/A' }}</td></tr>
        <tr><td>No Telepon</td><td>:</td><td>{{ optional($student->student->studentParent)->user->phone ?? '-' }}</td></tr>
        <tr><td>Hubungan</td><td>:</td><td>{{ optional($student->student->studentParent)->family_relation ?? 'N/A' }}</td></tr>
        <tr><td>Alamat</td><td>:</td><td>{{ optional($student->student->studentParent)->user->address ?? '-' }}</td></tr>
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
            <tr><td colspan="5" class="text-center">Tidak ada data prestasi</td></tr>
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
            <tr><td colspan="5" class="text-center">Tidak ada data pelanggaran</td></tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda tangan kepala sekolah -->
    <div style="width: 100%; margin-top: 60px; font-size: 12px;">
        <div style="width: 28%; margin-left: auto; text-align: left;">
            <div>Surabaya, {{ date('d F Y') }}</div>
            <div><strong>Kepala Sekolah</strong></div>
            <div><em>Mengetahui</em></div>
            <br><br><br><br><br>
            <div><strong><u>Dra. Ismy Latifaty, M.Pd.</u></strong></div>
            <div>NIP 19670214199703205</div>
        </div>
    </div>

    <!-- Dicetak oleh -->
    <div style="width: 100%; text-align: justify; font-size: 11px; margin-top: 80px;">
        <hr style="margin-bottom: 4px; border-top: 1px dashed #999;">
        <div style="display: flex; justify-content: space-between;">
            <span>*Dicetak oleh: <strong>{{ $user->name }}</strong></span>
            <span>{{ date('d F Y') }} - {{ ucfirst($user->getRoleNames()->first() ?? 'Pengguna') }}</span>
        </div>
    </div>

</body>
</html>
