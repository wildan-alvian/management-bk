@extends('layout.index')

@section('content')
<hr class="my-3">
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Daftar Siswa</h4>
    <div class="d-flex">
        <form method="GET" action="{{ route('students.index') }}" class="d-flex align-items-center">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari nama siswa" style="max-width: 150px;">
            <button type="submit" class="btn btn-outline-secondary me-2">
                <i class="bi bi-search"></i>
            </button>
            <div class="dropdown me-2">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownKelas" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-funnel"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownKelas">
                    <li><a class="dropdown-item" href="{{ route('students.index', array_merge(request()->all(), ['kelas' => '7'])) }}">Kelas 7</a></li>
                    <li><a class="dropdown-item" href="{{ route('students.index', array_merge(request()->all(), ['kelas' => '8'])) }}">Kelas 8</a></li>
                    <li><a class="dropdown-item" href="{{ route('students.index', array_merge(request()->all(), ['kelas' => '9'])) }}">Kelas 9</a></li>
                </ul>
            </div>
        </form>

        @if(request('search') || request('kelas'))
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary me-2">
                <i class="bi bi-x-circle-fill"></i>
            </a>
        @endif

        <a href="{{ route('students.create') }}" class="btn text-white fw-bold btn-orange">
            + Tambah Siswa
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($students as $index => $student)
                <tr>
                    <td>{{ $students->firstItem() + $index }}</td>
                    <td>{{ $student->nisn }}</td>
                    <td>{{ $student->nama_lengkap }}</td>
                    <td>{{ $student->kelas }}</td>
                    <td>{{ $student->email_siswa }}</td>
                    <td>{{ $student->telepon_siswa }}</td>
                    <td>
                        <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-link" style="font-size: 18px;">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a>
                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">@csrf</form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-muted">Tidak ada data siswa yang tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-end mt-2">
    {{ $students->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endsection
