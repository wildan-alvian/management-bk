<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pelanggaran</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 12px; margin: 20px; }
        .divider { border-bottom: 2px solid #000; margin: 10px 0 20px; }
        h3 { text-align: center; margin: 15px 0; font-size: 16px; text-transform: uppercase; }
        h4 { margin: 10px 0; font-size: 14px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #000; }
        td { padding: 6px 8px; vertical-align: top; }
        .label { width: 180px; font-weight: bold; }
    </style>
</head>
<body>
    {{-- Kop Surat --}}
    <table width="100%" style="border: none;">
        <tr style="border: none;">
            <td style="border: none; width: 100px; text-align: center; vertical-align: middle;">
                <img src="{{ public_path('asset/images/logo-dispendik.png') }}" style="height: 85px;">
            </td>
            <td style="border: none; text-align: center;">
                <p style="margin: 0; font-size: 11px;">PEMERINTAH KOTA SURABAYA</p>
                <p style="margin: 2px 0; font-size: 16px; font-weight: bold;">SMP NEGERI 22 SURABAYA</p>
                <p style="margin: 2px 0; font-size: 11px;">Jalan Gayungsari Barat X/38 Surabaya 60235</p>
                <p style="margin: 2px 0; font-size: 11px;">Telepon (031) 8290075</p>
                <p style="margin: 2px 0; font-size: 10px;">
                    Laman: <span style="text-decoration: underline; color: #0066cc;">https://www.smpn22sby.sch.id/</span> |
                    Posel: <span style="text-decoration: underline; color: #0066cc;">dapudasurabaya@gmail.com</span>
                </p>
            </td>
            <td style="border: none; width: 100px; text-align: center; vertical-align: middle;">
                <img src="{{ public_path('asset/images/dapuda.png') }}" style="height: 85px;">
            </td>
        </tr>
    </table>

    <div class="divider"></div>

    {{-- Judul --}}
    <h3>Detail Pelanggaran Siswa</h3>

    {{-- Data Siswa --}}
    <h4>Identitas Siswa</h4>
<table>
    <tr>
        <td class="label">NISN</td>
        <td>{{ $misconduct->student->nisn ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Nama Lengkap</td>
        <td>{{ $misconduct->student->user->name ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Email</td>
        <td>{{ $misconduct->student->user->email ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">No. Telepon</td>
        <td>{{ $misconduct->student->user->phone ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Kelas</td>
        <td>{{ $misconduct->student->class ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Jenis Kelamin</td>
        <td>{{ $misconduct->student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
    </tr>
    <tr>
        <td class="label">Tempat Lahir</td>
        <td>{{ $misconduct->student->birthplace ?? '-' }}</td>
    </tr>
    <tr>
        <td class="label">Tanggal Lahir</td>
        <td>{{ $misconduct->student->birthdate ? \Carbon\Carbon::parse($misconduct->student->birthdate)->translatedFormat('d F Y') : '-' }}</td>
    </tr>
    <tr>
        <td class="label">Alamat</td>
        <td>{{ $misconduct->student->user->address ?? '-' }}</td>
    </tr>
</table>


    {{-- Data Pelanggaran --}}
    <h4>Data Pelanggaran</h4>
    <table>
        <tr>
            <td class="label">Nama Pelanggaran</td>
            <td>{{ $misconduct->name }}</td>
        </tr>
        <tr>
            <td class="label">Kategori</td>
            <td>{{ $misconduct->category }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td>{{ \Carbon\Carbon::parse($misconduct->date)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Detail</td>
            <td>{{ $misconduct->detail }}</td>
        </tr>
    </table>

    {{-- Data Tindak Lanjut --}}
    @if ($misconduct->followUp)
    <h4>Tindak Lanjut</h4>
    <table>
        <tr>
            <td class="label">Catatan</td>
            <td>{{ $misconduct->followUp->note }}</td>
        </tr>
    </table>
    @endif

    {{-- Tanda tangan Kepala Sekolah --}}
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

    {{-- Dicetak oleh --}}
    <div style="width: 100%; font-size: 11px; margin-top: 80px;">
        <hr style="margin-bottom: 4px; border-top: 1px dashed #999;">
        <div style="display: flex; justify-content: space-between;">
            <span>*Dicetak oleh: <strong>{{ Auth::user()->name }}</strong></span>
            <span>{{ date('d F Y') }} - {{ ucfirst(Auth::user()->getRoleNames()->first() ?? 'Pengguna') }}</span>
        </div>
    </div>

</body>
</html>
