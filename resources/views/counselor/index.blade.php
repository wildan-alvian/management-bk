@extends('layout.index')

@section('content')
<div class="container mt-5" style="font-family: 'Kumbh Sans';">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <img src="{{ asset('asset/images/profile.png') }}" alt="Foto Profil" class="rounded-circle me-3" width="45" height="45">
                <div>
                    <h5 class="mb-0 fw-bold">M. Wildan Alvian Prastya</h5>
                    <small class="text-muted">Administrator</small>
                </div>
            </div>
        </div>
        <hr class="my-3"> 
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Daftar Guru BK</h4>
            <div class="d-flex">
                <form method="GET" action="{{ route('guru-bk.index') }}" class="d-flex">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control me-0" placeholder="Cari nama guru BK" style="max-width: 150px;">
                    <button type="submit" class="btn btn-outline-secondary me-3">
                        <i class="bi bi-search"></i> 
                    </button>
                </form>    

                @if(request('search'))
                <a href="{{ route('guru-bk.index') }}" class="btn btn-outline-secondary me-3"> <i class="bi bi-x-circle-fill"></i>
                @endif

                <a href="{{ route('guru-bk.create') }}" class="btn text-white fw-bold btn-orange">+ Tambah Guru BK</a>
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
                    @foreach ($counselor as $index => $guru)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $guru->nip }}</td>
                        <td>{{ $guru->nama }}</td>
                        <td>{{ $guru->email }}</td>
                        <td>{{ $guru->no_telepon }}</td>
                        <td>
                            <a href="{{ route('guru-bk.show', $guru->id) }}" class="btn btn-sm btn-link" style="font-size: 18px;">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                        </td>
                    </tr>   
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $counselor->links() }}
        </div>
    </div>
</div>
@endsection
