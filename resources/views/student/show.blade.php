@extends('layout.index')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-person-lines-fill me-2"></i>Detail Data Siswa
    </h4>
    
    <div class="d-flex gap-2">
        @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor']))
            <a href="{{ route('students.exportPdf', $student->id) }}" class="btn btn-outline-danger">
                <i class="bi bi-file-earmark-pdf me-1"></i>
                Export PDF
            </a>
        @endif
        @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor', 'Student Parents']))
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
                <i></i>
                Kembali
            </a>
        @endif
    </div>
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
    <!-- Data Siswa -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-person-vcard me-2"></i>
                    Data Siswa
                </h5>

                <div class="mb-3">
                    <label class="form-label text-muted">NISN</label>
                    <p class="fw-medium mb-0">{{ $student->student->nisn }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Nama Lengkap</label>
                    <p class="fw-medium mb-0">{{ $student->name }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Email</label>
                    <p class="fw-medium mb-0">{{ $student->email }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">No. Telepon</label>
                    <p class="fw-medium mb-0">{{ $student->phone ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Kelas</label>
                    <p class="fw-medium mb-0">{{ $student->student->class }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Jenis Kelamin</label>
                    <p class="fw-medium mb-0">{{ $student->student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Tempat Lahir</label>
                    <p class="fw-medium mb-0">{{ $student->student->birthplace ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Tanggal Lahir</label>
                    <p class="fw-medium mb-0">{{ $student->student->birthdate ? date('d F Y', strtotime($student->student->birthdate)) : '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Alamat</label>
                    <p class="fw-medium mb-0">{{ $student->address ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Wali -->
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-people me-2"></i>
                    Data Wali
                </h5>

                <div class="mb-3">
                    <label class="form-label text-muted">Nama Wali</label>
                    <p class="fw-medium mb-0">{{ optional($student->student->studentParent)->user->name ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Email</label>
                    <p class="fw-medium mb-0">{{ optional($student->student->studentParent)->user->email ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">No. Telepon</label>
                    <p class="fw-medium mb-0">{{ optional($student->student->studentParent)->user->phone ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Hubungan</label>
                    <p class="fw-medium mb-0">{{ optional($student->student->studentParent)->family_relation ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Alamat</label>
                    <p class="fw-medium mb-0">{{ optional($student->student->studentParent)->user->address ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Achievements Section -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-trophy me-2"></i>
                        Prestasi Siswa
                    </h5>
                    @can('edit-student')
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#achievementModal">
                        <i class="bi bi-plus-lg me-1"></i>
                        Tambah Prestasi
                    </button>
                    @endcan
                </div>

                <div class="table-responsive" style="min-height: fit-content">
                    <table class="table table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 25%;">Nama Prestasi</th>
                                <th style="width: 15%;">Kategori</th>
                                <th style="width: 15%;">Tanggal</th>
                                <th style="width: 20%;">Lampiran</th>
                                <th style="width: 30%;">Detail</th>
                                @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor']))
                                <th style="width: 10%;">Aksi</th>
                                @endif
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($student->student->achievements as $index => $achievement)
                            <tr id="achievement-{{ $achievement->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $achievement->name }}</td>
                                <td>{{ $achievement->category }}</td>
                                <td>{{ date('d F Y', strtotime($achievement->date)) }}</td>
                                <td>
                                    @if($achievement->file)
                                <a href="{{ Storage::url($achievement->file) }}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-paperclip me-1"></i>Lihat Lampiran</a>
                                @endif
                                </td>                                
                                <td>{{ $achievement->detail }}</td>
                                <td>
                                    @can('edit-student')
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-warning btn-sm edit-achievement" 
                                            data-id="{{ $achievement->id }}"
                                            data-name="{{ $achievement->name }}"
                                            data-category="{{ $achievement->category }}"
                                            data-date="{{ $achievement->date }}"
                                            data-detail="{{ $achievement->detail }}"
                                            data-file="{{ $achievement->file }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm delete-achievement" data-id="{{ $achievement->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr id="no-achievements">
                                <td colspan="7" class="text-center py-3 text-muted">Tidak ada data prestasi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Misconducts Section -->
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Pelanggaran Siswa
                    </h5>
                    @can('edit-student')
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#misconductModal">
                        <i class="bi bi-plus-lg me-1"></i>
                        Tambah Pelanggaran
                    </button>
                    @endcan
                </div>

                <div class="table-responsive" style="min-height: fit-content">
                    <table class="table table-hover text-center align-middle" id="misconductsTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 25%;">Nama Pelanggaran</th>
                                <th style="width: 15%;">Kategori</th>
                                <th style="width: 15%;">Tanggal</th>
                                <th style="width: 20%;">Lampiran</th>
                                <th style="width: 30%;">Keterangan</th>
                                <th style="width: 10%;">Aksi</th>
                                </tr>
                        </thead>
                        <tbody>
                            @forelse($student->student->misconducts as $index => $misconduct)
                            <tr id="misconduct-{{ $misconduct->id }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $misconduct->name }}</td>
                                <td>{{ $misconduct->category }}</td>
                                <td>{{ date('d F Y', strtotime($misconduct->date)) }}</td>
                                <td>
                                    @if($misconduct->file)
                                    <a href="{{ Storage::url($misconduct->file) }}" target="_blank" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-paperclip me-1"></i>Lihat Lampiran
                                    </a>
                                    @endif
                                </td>
                                <td>{{ $misconduct->detail }}</td>
                            
                                {{-- INI SELALU MEMUNCULKAN KOLOM <td> AGAR TIDAK LOMPAT BARIS --}}
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light border" type="button" id="dropdownMenuButton{{ $misconduct->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $misconduct->id }}">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('student-misconducts.show', $misconduct->id) }}">
                                                    <i class="bi bi-eye me-2"></i> Detail
                                                </a>
                                            </li>
                                            @can('edit-student')
                                            <li>
                                                <a class="dropdown-item edit-misconduct" href="javascript:void(0);"
                                                    data-id="{{ $misconduct->id }}"
                                                    data-name="{{ $misconduct->name }}"
                                                    data-category="{{ $misconduct->category }}"
                                                    data-date="{{ $misconduct->date }}"
                                                    data-detail="{{ $misconduct->detail }}">
                                                    <i class="bi bi-pencil-square me-2"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger delete-misconduct" href="javascript:void(0);" data-id="{{ $misconduct->id }}">
                                                    <i class="bi bi-trash me-2"></i> Hapus
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr id="no-misconducts">
                                <td colspan="7" class="text-center py-3 text-muted">Tidak ada data pelanggaran</td>
                            </tr>
                            @endforelse
                            </tbody>                            
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('student.partials.achievement-modal')
@include('student.partials.misconduct-modal')

@endsection
