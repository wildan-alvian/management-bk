@extends('layout.index') 

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold mb-0">Daftar Admin</h4>
    <div class="d-flex">
        <form method="GET" action="{{ route('admin.index') }}" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari nama/email/NIP">
            <button type="submit" class="btn btn-outline-secondary me-3">
                <i class="bi bi-search"></i>
            </button>
        </form>
        @if(isset($search))
            <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary me-3">
                <i class="bi bi-x-circle-fill"></i>
            </a>
        @endif
        <a href="{{ route('admin.create') }}" class="btn btn-add">
            <i class="bi bi-plus-lg"></i>
            Tambah Admin
        </a>
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
            @forelse($admins as $admin)
            <tr>
                <td class="text-center">{{ $admins->firstItem() + $loop->index }}</td>
                <td>{{ $admin->id_number }}</td>
                <td>{{ $admin->name }}</td>
                <td>{{ $admin->email }}</td>
                <td>{{ $admin->phone ?? '-' }}</td>
                <td class="text-center">
                    @if(!$admin->hasRole('Super Admin'))
                        <div class="dropdown">
                            <a class="btn btn-sm" style="font-size: 18px;" href="#" role="button" id="dropdownMenuLink{{ $admin->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $admin->id }}">
                                <a class="dropdown-item" href="{{ route('admin.show', $admin) }}">
                                    <i class="bi bi-eye me-2"></i>Detail
                                </a>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $admin->id }}">
                                    <i class="bi bi-pencil me-2"></i>Edit
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $admin->id }}">
                                    <i class="bi bi-trash me-2"></i>Hapus
                                </a>
                            </div>
                        </div>

                        @include('admin.partials._edit_modal', ['admin' => $admin])
                        @include('admin.partials._delete_modal', ['admin' => $admin])

                    @else
                        <span class="badge bg-primary">Super Admin</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-4">
                    @if(isset($search))
                        Tidak ada admin yang ditemukan dengan kata kunci: "{{ $search }}"
                    @else
                        Tidak ada data admin yang tersedia.
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-end mt-3">
    {{ $admins->links() }}
</div>

@endsection
