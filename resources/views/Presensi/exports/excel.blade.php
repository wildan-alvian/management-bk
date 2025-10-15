<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NISN</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Tanggal/Waktu</th>
            <th>Status</th>
            <th>Deskripsi</th>
            <th>Lampiran/Foto</th>
        </tr>
    </thead>
    <tbody>
        @foreach($presensi as $index => $p)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $p->user->student->nisn ?? '-' }}</td>
            <td>{{ $p->user->name }}</td>
            <td>{{ $p->user->student->class ?? '-' }}</td>
            <td>{{ $p->tanggal_waktu }}</td>
            <td>{{ ucfirst($p->status) }}</td>
            <td>{{ $p->deskripsi ?? '-' }}</td>
            <td>
                @php
                    $filePath = null;
                    if ($p->lampiran) {
                        $filePath = asset('storage/' . $p->lampiran);
                    } elseif ($p->foto) {
                        $filePath = asset('storage/' . $p->foto);
                    }
                @endphp

                @if($filePath)
                    <a href="{{ $filePath }}" target="_blank">{{ $filePath }}</a>
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
