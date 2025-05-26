@extends('layout.index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0"><i class="bi bi-people-fill me-2"></i>Daftar Siswa</h4>
    
    <div class="d-flex align-items-center flex-wrap gap-2">
        <!-- Search Form -->
        <form method="GET" action="{{ route('students.index') }}" class="d-flex align-items-center" id="filterForm">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari nama/email/NISN/kelas">
            <button type="submit" class="btn btn-outline-secondary me-2">
                <i class="bi bi-search"></i>
            </button>
        </form>

        <!-- Filter Dropdown -->
        @can('create-student')
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-funnel-fill me-1"></i>
            </button>
            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item {{ request('class_filter') == '7' ? 'active' : '' }}" href="?class_filter=7">Kelas 7</a></li>
                <li><a class="dropdown-item {{ request('class_filter') == '8' ? 'active' : '' }}" href="?class_filter=8">Kelas 8</a></li>
                <li><a class="dropdown-item {{ request('class_filter') == '9' ? 'active' : '' }}" href="?class_filter=9">Kelas 9</a></li>
            </ul>
            @endcan
        </div>

        <!-- Clear Filter Button -->
        @if(request('search') || request('class_filter'))
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary" title="Reset filter">
                <i class="bi bi-x-circle-fill"></i>
            </a>
        @endif

        <!-- Tambah Siswa -->
        @can('create-student')
            <a href="{{ route('students.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Tambah Siswa
            </a>
        @endcan
    </div>
</div>

<!-- Alerts -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-1"></i>
        {!! nl2br(e(session('success'))) !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-1"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Table -->
<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th class="fw bold text-center" style="width: 5%;"></i>No</th>
                <th class="fw bold"><i class="bi bi-card-list me-1"></i> NISN</th>
                <th class="fw bold"><i class="bi bi-person-fill me-1"></i> Nama</th>
                <th class="fw bold"><i class="bi bi-building me-1"></i> Kelas</th>
                <th class="fw bold"><i class="bi bi-person-lines-fill me-1"></i> Wali</th>
                <th class="fw bold"><i class="bi bi-people me-1"></i> Hubungan</th>
                <th class="fw-bold text-center"><i class="bi bi-gear-fill me-1"></i>Aksi</th>
                </tr>
        </thead>
        <tbody>
            @forelse ($students as $index => $student)
                <tr>
                    <td class="text-center">{{ $students->firstItem() + $index }}</td>
                    <td>{{ optional($student->student)->nisn ?? 'N/A' }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ optional($student->student)->class ?? 'N/A' }}</td>
                    <td>{{ optional(optional($student->student)->studentParent)->user->name ?? 'N/A' }}</td>
                    <td>{{ optional(optional($student->student)->studentParent)->family_relation ?? 'N/A' }}</td>
                    <td class="text-center">
                        <div class="dropdown">
                            <a class="btn btn-light btn-sm rounded-circle shadow-sm border-0" href="#" role="button" id="dropdownMenuLink{{ $student->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $student->id }}">
                                @can('view-student')
                                    <a class="dropdown-item" href="{{ route('students.show', $student->id) }}">
                                        <i class="bi bi-eye me-2"></i>Detail
                                    </a>
                                @endcan
                                @can('edit-student')
                                    <a class="dropdown-item" href="{{ route('students.edit', $student->id) }}">
                                        <i class="bi bi-pencil me-2"></i>Edit
                                    </a>
                                @endcan
                                @can('delete-student')
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $student->id }}">
                                        <i class="bi bi-trash me-2"></i>Hapus
                                    </a>
                                @endcan
                            </div>
                        </div>
                        @can('delete-student')
                            @include('student.partials._delete_modal', ['student' => $student])
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        @if(request('search') || request('class_filter'))
                            Tidak ada siswa yang ditemukan dengan kata kunci atau filter tersebut.
                        @else
                            Tidak ada data siswa yang tersedia.
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-end mt-3">
    {{ $students->appends(request()->query())->links() }}
</div>
@endsection
