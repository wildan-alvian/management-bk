@extends('layout.index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Daftar Guru BK</h4>
    <div class="d-flex">
        <form method="GET" action="{{ route('counselors.index') }}" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari nama/email/NIP">
            <button type="submit" class="btn btn-outline-secondary me-3">
                <i class="bi bi-search"></i>
            </button>
        </form>

        @if(request('search'))
            <a href="{{ route('counselors.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-x-circle-fill"></i>
            </a>
        @endif

        @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
            <a href="{{ route('counselors.create') }}" class="btn btn-add">
                <i class="bi bi-plus-lg"></i>
                Tambah Guru BK
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

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th class="text-center" style="width: 5%;">No.</th>
                <th style="width: 15%;">NIP</th>
                <th style="width: 25%;">Nama</th>
                <th style="width: 25%;">Email</th>
                <th style="width: 20%;">No. Telepon</th>
                <th class="text-center" style="width: 10%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($counselors as $index => $counselor)
                <tr>
                    <td class="text-center">{{ $counselors->firstItem() + $index }}</td>
                    <td>{{ $counselor->nip }}</td>
                    <td>{{ $counselor->name }}</td>
                    <td>{{ $counselor->email }}</td>
                    <td>{{ $counselor->phone ?? '-' }}</td>
                    <td class="text-center">
                        <div class="dropdown">
                            <a class="btn btn-sm" style="font-size: 18px;" href="#" role="button" id="dropdownMenuLink{{ $counselor->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $counselor->id }}">
                                <a class="dropdown-item" href="{{ route('counselors.show', $counselor) }}">
                                    <i class="bi bi-eye me-2"></i>Detail
                                </a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $counselor->id }}">
                                    <i class="bi bi-pencil me-2"></i>Edit
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $counselor->id }}">
                                    <i class="bi bi-trash me-2"></i>Hapus
                                </a>
                            </div>
                        </div>

                        @include('counselor.partials._edit_modal', ['counselor' => $counselor])
                        @include('counselor.partials._delete_modal', ['counselor' => $counselor])
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        @if(request('search'))
                            Tidak ada guru BK yang ditemukan dengan kata kunci: "{{ request('search') }}"
                        @else
                            Tidak ada data guru BK yang tersedia.
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-end mt-3">
    {{ $counselors->links() }}
</div>

@endsection
