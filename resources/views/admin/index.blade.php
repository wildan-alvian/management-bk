@extends('layout.index') 

@section('content')
<div class="row align-items-center mb-4 g-2">
  <div class="col-12 col-md-auto mb-2 mb-md-0">
    <h4 class="fw-bold mb-0"><i class="bi bi-people-fill me-2"></i>Daftar Admin</h4>
  </div>
  <div class="col-12 col-md d-flex justify-content-md-end flex-wrap gap-2">
    <form method="GET" action="{{ route('admin.index') }}" class="d-flex me-2">
      <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari nama/email/NIP">
      <button type="submit" class="btn btn-outline-secondary">
        <i class="bi bi-search"></i>
      </button>
    </form>
    @if(request('search'))
      <a href="{{ route('admin.index') }}" class="btn btn-outline-danger me-2" title="Reset Pencarian">
        <i class="bi bi-x-circle-fill"></i>
      </a>
    @endif
    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModal">
        <i class="bi bi-upload"></i> Import
    </button>
    <a href="{{ route('admin.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg me-1"></i>Tambah Admin
    </a>
  </div>
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

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary">
                    <tr>
                        <th class="fw-bold text-center"></i>No</th>
                        <th class="fw-bold"><i class="bi bi-card-list me-1"></i>NIP</th>
                        <th class="fw-bold"><i class="bi bi-person-badge-fill me-1"></i>Nama</th>
                        <th class="fw-bold text-center"><i class="bi bi-envelope-fill me-1"></i>Email</th>
                        <th class="fw-bold"><i class="bi bi-telephone-fill me-1"></i>No. Telepon</th>
                        <th class="fw-bold text-center"><i class="bi bi-gear-fill me-1"></i>Aksi</th>
                    </tr>                    
                </thead>
                

        <tbody>
            @forelse($admins as $admin)
            <tr>
                <td class="text-center">{{ $admins->firstItem() + $loop->index }}</td>
                <td class="text-start">{{ $admin->id_number }}</td>
                <td class="text-start">{{ $admin->name }}</td>
                <td class="text-start">{{ $admin->email }}</td>
                <td class="text-start">{{ $admin->phone ?? '-' }}</td>
                <td class="text-center">
                    @if(!$admin->hasRole('Super Admin'))
                        <div class="dropdown">
                            <button class="btn btn-light btn-sm rounded-circle shadow-sm border-0" id="dropdownMenuLink{{ $admin->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $admin->id }}">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.show', $admin) }}">
                                        <i class="bi bi-eye me-2"></i>Detail
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $admin->id }}">
                                        <i class="bi bi-pencil-square me-2"></i>Edit
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $admin->id }}">
                                        <i class="bi bi-trash3-fill me-2"></i>Hapus
                                    </a>
                                </li>
                            </ul>
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
                    @if(request('search'))
                        <i class="bi bi-info-circle me-1"></i>
                        Tidak ada admin yang ditemukan dengan kata kunci: <strong>"{{ request('search') }}"</strong>
                    @else
                        <i class="bi bi-info-circle me-1"></i>
                        Tidak ada data admin yang tersedia.
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Import -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="importModalLabel">Import Data Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="file" class="form-label">Upload File (Excel .xlsx/.csv)</label>
              <input type="file" class="form-control" name="file" accept=".xlsx,.xls" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Import</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  
@if($admins->total() > 10)
<div class="d-flex justify-content-end mt-3">
    {{ $admins->links() }}
</div>
@endif
@endsection
