@extends('layout.index')

@section('content')
<hr class="my-3">
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Daftar Guru BK</h4>
    <div class="d-flex">
        <form method="GET" action="{{ route('counselors.index') }}" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-0" placeholder="Cari nama guru BK" style="max-width: 150px;">
            <button type="submit" class="btn btn-outline-secondary me-3">
                <i class="bi bi-search"></i>
            </button>
        </form>

        @if(request('search'))
            <a href="{{ route('counselors.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-x-circle-fill"></i>
            </a>
        @endif

        @if(in_array(Auth::user()->role, ['Super Admin', 'Admin']))
            <a href="{{ route('counselors.create') }}" class="btn text-white fw-bold btn-orange">+ Tambah Guru BK</a>
        @endif
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Nomor Telepon</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tbody>
                @forelse ($counselor as $index => $guru)
                    <tr>
                        <td>{{ $counselor->firstItem() + $index }}</td>
                        <td>{{ $guru->nip }}</td>
                        <td>{{ $guru->nama }}</td>
                        <td>{{ $guru->email }}</td>
                        <td>{{ $guru->no_telepon }}</td>
                        <td>
                            <a href="{{ route('counselors.show', $guru->id) }}" class="btn btn-sm btn-link" style="font-size: 18px;">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-muted">Tidak ada data guru BK yang tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Informasi jumlah dan pagination --}}
        
            <div class="d-flex justify-content-end mt-2">
                {{ $counselor->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>

    
    @endsection
