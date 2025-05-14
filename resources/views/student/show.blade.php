@extends('layout.index')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold mb-4">Detail Data Siswa</h2>

    <div class="mb-4">
        <a href="{{ route('students.index') }}" class="fw-bold btn btn-sm rounded-pill btn-glow">
            <i class="bi bi-caret-left-fill me-1"></i> Kembali
        </a>         
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

    <div class="row">
        <!-- Data Siswa -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg p-4 bg-light rounded">
                <h5 class="fw-bold mb-3">Data Siswa</h5>

                <div class="mb-3">
                    <label class="fw-bold">NISN:</label>
                    <p class="mb-0">{{ $student->student->nisn }}</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Nama Lengkap:</label>
                    <p class="mb-0">{{ $student->name }}</p>
        </div>

                <div class="mb-3">
                    <label class="fw-bold">Email:</label>
                    <p class="mb-0">{{ $student->email }}</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Kelas:</label>
                    <p class="mb-0">{{ $student->student->class }}</p>
        </div>

                <div class="mb-3">
                    <label class="fw-bold">Jenis Kelamin:</label>
                    <p class="mb-0">{{ $student->student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Tempat Lahir:</label>
                    <p class="mb-0">{{ $student->student->birthplace ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Tanggal Lahir:</label>
                    <p class="mb-0">{{ $student->student->birthdate ? date('d F Y', strtotime($student->student->birthdate)) : '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Data Wali -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-lg p-4 bg-light rounded">
                <h5 class="fw-bold mb-3">Data Wali</h5>

                <div class="mb-3">
                    <label class="fw-bold">Nama Wali:</label>
                    <p class="mb-0">{{ optional($student->student->studentParent)->user->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Email:</label>
                    <p class="mb-0">{{ optional($student->student->studentParent)->user->email ?? 'N/A' }}</p>
        </div>

                <div class="mb-3">
                    <label class="fw-bold">No. Telepon:</label>
                    <p class="mb-0">{{ optional($student->student->studentParent)->user->phone ?? '-' }}</p>
        </div>

                <div class="mb-3">
                    <label class="fw-bold">Hubungan:</label>
                    <p class="mb-0">{{ optional($student->student->studentParent)->family_relation ?? 'N/A' }}</p>
                </div>
                        
                        <div class="mb-3">
                    <label class="fw-bold">Alamat:</label>
                    <p class="mb-0">{{ optional($student->student->studentParent)->user->address ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Achievements Section -->
    <div class="card shadow-lg p-4 bg-light rounded mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Prestasi Siswa</h5>
            @can('edit-student')
            <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#achievementModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah Prestasi
            </button>
            @endcan
        </div>

<div class="table-responsive">
            <table class="table table-hover" id="achievementsTable">
    <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Prestasi</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                        <th>Detail</th>
                        <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                    @forelse($student->student->achievements as $index => $achievement)
                    <tr id="achievement-{{ $achievement->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $achievement->name }}</td>
                        <td>{{ $achievement->category }}</td>
                        <td>{{ date('d F Y', strtotime($achievement->date)) }}</td>
                        <td>{{ $achievement->detail }}</td>
                        <td>
                            @can('edit-student')
                            <button type="button" class="btn btn-warning btn-sm edit-achievement" 
                                data-id="{{ $achievement->id }}"
                                data-name="{{ $achievement->name }}"
                                data-category="{{ $achievement->category }}"
                                data-date="{{ $achievement->date }}"
                                data-detail="{{ $achievement->detail }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>                            
                            <button type="button" class="btn btn-danger btn-sm delete-achievement" data-id="{{ $achievement->id }}">
                                <i class="bi bi-trash"></i>
                                </button>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr id="no-achievements">
                        <td colspan="6" class="text-center">Tidak ada data prestasi</td>
                    </tr>
                    @endforelse
            </tbody>
        </table>
        </div>
    </div>

    <!-- Student Misconducts Section -->
    <div class="card shadow-lg p-4 bg-light rounded mb-4">
<div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Pelanggaran Siswa</h5>
            @can('edit-student')
            <button type="button" class="btn btn-primary btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#misconductModal">
                <i class="bi bi-plus-circle me-1"></i> Tambah Pelanggaran
    </button>
            @endcan
</div>

<div class="table-responsive">
            <table class="table table-hover" id="misconductsTable">
    <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggaran</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                        <th>Detail</th>
                        <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                    @forelse($student->student->misconducts as $index => $misconduct)
                    <tr id="misconduct-{{ $misconduct->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $misconduct->name }}</td>
                        <td>{{ $misconduct->category }}</td>
                        <td>{{ date('d F Y', strtotime($misconduct->date)) }}</td>
                        <td>{{ $misconduct->detail }}</td>
                        <td>
                            @can('edit-student')
                            <button type="button" class="btn btn-warning btn-sm edit-misconduct" 
                                data-id="{{ $misconduct->id }}"
                                data-name="{{ $misconduct->name }}"
                                data-category="{{ $misconduct->category }}"
                                data-date="{{ $misconduct->date }}"
                                data-detail="{{ $misconduct->detail }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delete-misconduct" data-id="{{ $misconduct->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr id="no-misconducts">
                        <td colspan="6" class="text-center">Tidak ada data pelanggaran</td>
                    </tr>
                    @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

@include('student.partials.achievement-modal')
@include('student.partials.misconduct-modal')

@endsection
