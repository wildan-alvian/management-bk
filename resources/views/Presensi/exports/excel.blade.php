<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Tanggal/Waktu</th>
            <th>Status</th>
            <th>Deskripsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($presensi as $index => $p)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $p->user->name }}</td>
            <td>{{ $p->tanggal_waktu }}</td>
            <td>{{ ucfirst($p->status) }}</td>
            <td>{{ $p->deskripsi ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
