@extends('layout.index')

@section('content')
<div class="container-fluid">
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

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Daftar Konseling</h4>
        <div class="d-flex">
            <form method="GET" action="{{ route('counseling.index') }}" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari judul konseling"">
                <button type="submit" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <form method="GET" action="{{ route('counseling.index') }}" class="d-flex me-3">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary d-flex align-items-center" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-funnel me-1"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                        {{-- Filter Status --}}
                        <li><h6 class="dropdown-header">Status</h6></li>
                        <li><a class="dropdown-item" href="{{ route('counseling.index', array_merge(request()->except('page'), ['status' => 'new'])) }}">New</a></li>
                        <li><a class="dropdown-item" href="{{ route('counseling.index', array_merge(request()->except('page'), ['status' => 'approved'])) }}">Approved</a></li>
                        <li><a class="dropdown-item" href="{{ route('counseling.index', array_merge(request()->except('page'), ['status' => 'rejected'])) }}">Rejected</a></li>
                        <li><a class="dropdown-item" href="{{ route('counseling.index', array_merge(request()->except('page'), ['status' => 'canceled'])) }}">Canceled</a></li>
                        <li><hr class="dropdown-divider"></li>
            
                        {{-- Filter Tipe Konseling --}}
                        <li><h6 class="dropdown-header">Tipe Konseling</h6></li>
                        <li><a class="dropdown-item" href="{{ route('counseling.index', array_merge(request()->except('page'), ['counseling_type' => 'siswa'])) }}">Siswa</a></li>
                        <li><a class="dropdown-item" href="{{ route('counseling.index', array_merge(request()->except('page'), ['counseling_type' => 'wali_murid'])) }}">Wali Murid</a></li>
                    </ul>
                </div>
            </form>
            
            {{-- Reset Filter Button --}}
            @if(request('status') || request('counseling_type'))
                <a href="{{ route('counseling.index') }}" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-x-circle-fill"></i>
                </a>
            @endif
            
            


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
                                $statusColors = ['new' => 'warning', 'approved' => 'success', 'rejected' => 'danger', 'canceled' => 'secondary'];
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
                                    <a class="dropdown-item" href="{{ route('counseling.show', $counseling->id) }}">
                                        <i class="bi bi-eye me-2"></i>Detail
                                    </a> 
                                    @if(Auth::user()->hasRole(['Guidance Counselor']) && $counseling->status !== 'canceled')
                                        <div class="dropdown-divider"></div>  
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $counseling->id }}">
                                            <i class="bi bi-pencil me-2"></i>Cancel
                                        </a>
                                    @endif 
                                    @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                        <div class="dropdown-divider"></div>  
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $counseling->id }}">
                                            <i class="bi bi-pencil me-2"></i>Edit
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $counseling->id }}">
                                            <i class="bi bi-trash me-2"></i>Hapus
                                        </a>
                                    @endif
                                </div>
                            </div>

                            
                            @if(Auth::user()->hasRole(['Guidance Counselor']))
                                @include('counseling.partials._cancel_modal', ['counseling' => $counseling])
                            @endif

                            @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
                                @include('counseling.partials._edit_modal', ['counseling' => $counseling])
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
</div>
@endsection
