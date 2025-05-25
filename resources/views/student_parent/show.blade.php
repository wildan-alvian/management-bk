@extends('layout.index')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0"><i class="bi bi-person-vcard me-2"></i>Detail Data Wali Murid</h4>
    <a href="{{ route('student-parents.index') }}" class="btn btn-outline-secondary">
        <i></i>Kembali
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <div class="card shadow-sm p-4 mb-4 border-0">
        <h5 class="fw-bold mb-4"><i class="bi bi-person-lines-fill me-2"></i>Informasi Wali Murid</h5>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="card p-3 border-start border-primary border-3 shadow-sm">
                    <i class="bi bi-credit-card-2-front text-primary mb-2 fs-4"></i>
                    <strong>NIK:</strong>
                    <p class="mb-0">{{ $studentParent->id_number }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 border-start border-success border-3 shadow-sm">
                    <i class="bi bi-person-fill text-success mb-2 fs-4"></i>
                    <strong>Nama:</strong>
                    <p class="mb-0">{{ $studentParent->name }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 border-start border-warning border-3 shadow-sm">
                    <i class="bi bi-envelope-at text-warning mb-2 fs-4"></i>
                    <strong>Email:</strong>
                    <p class="mb-0">{{ $studentParent->email }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 border-start border-info border-3 shadow-sm">
                    <i class="bi bi-telephone-fill text-info mb-2 fs-4"></i>
                    <strong>No Telepon:</strong>
                    <p class="mb-0">{{ $studentParent->phone }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 border-start border-dark border-3 shadow-sm">
                    <i class="bi bi-diagram-2-fill text-dark mb-2 fs-4"></i>
                    <strong>Hubungan:</strong>
                    <p class="mb-0">{{ $studentParent->studentParent->family_relation }}</p>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card p-3 border-start border-secondary border-3 shadow-sm">
                    <i class="bi bi-geo-alt-fill text-secondary mb-2 fs-4"></i>
                    <strong>Alamat:</strong>
                    <p class="mb-0">{{ $studentParent->address }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0"><i class="bi bi-people-fill me-2"></i>Daftar Siswa</h5>
        </div>

        <div class="table-responsive rounded shadow-sm border">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        @unless(Auth::user()->hasRole(['Student Parents', 'Student']))
                        <th class="text-center" style="width: 5%;">No</th>
                        @endunless
                        <th><i class="bi bi-person-badge me-1"></i> NISN</th>
                        <th><i class="bi bi-person me-1"></i> Nama</th>
                        <th><i class="bi bi-envelope me-1"></i> Email</th>
                        <th><i class="bi bi-telephone me-1"></i> No. Telepon</th>
                        <th><i class="bi bi-building me-1"></i> Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studentParent->studentParent->students as $index => $student)
                    <tr id="student-{{ $student->id }}">
                        @unless(Auth::user()->hasRole(['Student Parents', 'Student']))
                        <td class="text-center">{{ $index + 1 }}</td>
                        @endunless
                        <td>{{ $student->nisn }}</td>
                        <td>{{ $student->user->name }}</td>
                        <td>{{ $student->user->email }}</td>
                        <td>{{ $student->user->phone }}</td>
                        <td>{{ $student->class }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-3 text-muted">
                            <i class="bi bi-exclamation-circle me-2"></i> Tidak ada data siswa
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        
    </div>
</div>

@endsection
