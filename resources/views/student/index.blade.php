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
            <h4 class="fw-bold mb-0">Daftar Siswa</h4>
            <div class="d-flex">
                <form method="GET" action="{{ route('students.index') }}" class="d-flex">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control me-0" placeholder="Cari nama siswa" style="max-width: 150px;">
                    <button type="submit" class="btn btn-outline-secondary me-3">
                        <i class="bi bi-search"></i> 
                    </button>
                </form>                

                @if(request('search'))
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary me-3"> <i class="bi bi-x-circle-fill"></i>
                @endif

                <a href="{{ route('students.create') }}" class="btn text-white fw-bold btn-orange">
                    + Tambah Siswa
                </a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
            <thead>
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
                @foreach ($students as $index => $student)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $student->nisn }}</td>
                <td>{{ $student->nama_lengkap }}</td> 
                <td>{{ $student->kelas }}</td>
                <td>{{ $student->email_siswa }}</td>
                <td>{{ $student->telepon_siswa }}</td>
                <td>
                    <a href="{{ route('students.show', $student->id) }}" class="btn btn-sm btn-link" style="font-size: 18px;">
                        <i class="bi bi-three-dots-vertical"></i>
                    </a>                    
                    
                    <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                        @csrf
                    </form>                    
            </td>
        </tr>   
        @endforeach
    </tbody>
</table>

        <div class="d-flex justify-content-end">
            {{ $students->links() }}
        </div>
    </div>
</div>
@endsection
