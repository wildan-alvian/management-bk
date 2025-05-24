@extends('layout.index')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Detail Data Wali Murid</h4>
    @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor', 'Student Parents']))
    <a href="{{ route('student-parents.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i>
        Kembali
    </a>
    @endif
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <div class="p-4 mb-5 card shadow-sm">
        <div class="row mb-3">
            <div class="col-md-12">
                <h5 class="fw-bold mb-4">
                <i class="bi bi-people me-2"></i>
                    Data Wali Murid
                </h5>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>NIK:</strong>
                    <p>{{ $studentParent->id_number }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Nama:</strong>
                    <p>{{ $studentParent->name }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Email:</strong>
                    <p>{{ $studentParent->email }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>No Telepon:</strong>
                    <p>{{ $studentParent->phone }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Hubungan:</strong>
                    <p>{{ $studentParent->studentParent->family_relation }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card p-3 shadow-sm">
                    <strong>Alamat:</strong>
                    <p>{{ $studentParent->address }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-person-vcard me-2"></i>
                        Daftar Siswa
                    </h5>
                </div>

                <div class="table-responsive" style="min-height: fit-content">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Kelas</th>
                                </tr>
                        </thead>
                        <thead class="table-light">
                            <tr>
                                @unless(Auth::user()->hasRole(['Student Parents', 'Student']))
                                <th style="width: 5%;">No</th>
                                @endunless
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($studentParent->studentParent->students as $index => $student)
                            <tr id="student-{{ $student->id }}">
                                @unless(Auth::user()->hasRole(['Student Parents', 'Student']))
                                <td>{{ $index + 1 }}</td>
                                @endunless
                                <td>{{ $student->nisn }}</td>
                                <td>{{ $student->user->name }}</td>
                                <td>{{ $student->user->email }}</td>
                                <td>{{ $student->user->phone }}</td>
                                <td>{{ $student->class }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 text-muted">Tidak ada data siswa</td>
                            </tr>
                            @endforelse
                        </tbody>
                        
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
