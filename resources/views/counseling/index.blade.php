@extends('layout.index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Daftar Konseling</h4>
    <div class="d-flex">
        <form method="GET" action="{{ route('counseling.index') }}" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari judul konseling"">
            <button type="submit" class="btn btn-outline-secondary me-3">
                <i class="bi bi-search"></i>
            </button>
        </form>

        @if(request('search'))
            <a href="{{ route('counseling.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-x-circle-fill"></i>
            </a>
        @endif

        <a href="{{ route('counseling.create') }}" class="btn btn-add">
            <i class="bi bi-plus-lg"></i>
            Tambah Konseling
        </a>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>Jadwal</th>
                <th>Diajukan Oleh</th>
                <th>Tipe Konseling</th>
                <th>Judul Konseling</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($counselings as $index => $counseling)
                <tr>
                    <td>{{ $counselings->firstItem() + $index }}</td>
                    <td>{{ $counseling->scheduled_at ? \Carbon\Carbon::parse($counseling->scheduled_at)->format('d M Y H:i') : '-' }}</td>
                    <td>{{ $counseling->submitted_by ?? '-' }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $counseling->counseling_type)) }}</td>
                    <td>{{ $counseling->title }}</td>
                    <td>
                        @php
                            $statusColors = ['new' => 'secondary', 'on_progress' => 'warning', 'approved' => 'success', 'rejected' => 'danger', 'canceled' => 'dark'];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$counseling->status] ?? 'secondary' }}">
                            {{ strtoupper(str_replace('_', ' ', $counseling->status)) }}
                        </span>
                    </td>
                    <td>
                        <div class="dropdown">
                            <a class="btn btn-sm" style="font-size: 18px;" href="#" role="button" id="dropdownMenuLink{{ $counseling->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $counseling->id }}">
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $counseling->id }}">
                                    <i class="bi bi-pencil me-2"></i>Edit
                                </a>
                                @if(Auth::user()->hasRole(['Super Admin', 'Admin', 'Guidance Counselor']))
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $counseling->id }}">
                                        <i class="bi bi-trash me-2"></i>Hapus
                                    </a>
                                @endif
                            </div>
                        </div>

                        @include('counseling.partials._edit_modal', ['counseling' => $counseling])
                        @if(Auth::user()->hasRole(['Super Admin', 'Admin', 'Guidance Counselor']))
                            @include('counseling.partials._delete_modal', ['counseling' => $counseling])
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-muted">Belum ada data konseling.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-end mt-4">
    {{ $counselings->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endsection
