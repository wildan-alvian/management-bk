@extends('layout.index')

@section('content')
    
<div class="row align-items-center mb-4 g-2">
    <div class="col-12 col-md-auto mb-2 mb-md-0">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-people-fill me-2"></i>Daftar Guru BK
        </h4>
    </div>
    <div class="col-12 col-md d-flex justify-content-md-end flex-wrap gap-2">
        <form method="GET" action="{{ route('counselors.index') }}" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari nama/email/NIP">
            <button type="submit" class="btn btn-outline-secondary me-2">
                <i class="bi bi-search"></i>
            </button>
        </form>
        @if(request('search'))
            <a href="{{ route('counselors.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle-fill"></i>
            </a>
        @endif
        @if(Auth::user()->hasRole(['Super Admin', 'Admin']))
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#importModal">
            <i class="bi bi-upload"></i> Import
        </button>
            <a href="{{ route('counselors.create') }}" class="btn btn-add">
                <i class="bi bi-plus-lg me-1"></i>Tambah Guru BK
            </a>
        @endif
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

<div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light fw-bold">
            <tr>
                <th class="fw-bold text-center"></i>No</th>
                <th class="fw bold"><i class="bi bi-card-list me-1"></i>NIP</th>
                <th class="fw-bold"><i class="bi bi-person-fill me-1"></i>Nama</th>
                <th class="fw-bold text-center"><i class="bi bi-envelope-fill me-1"></i>Email</th>
                <th class="fw-bold"><i class="bi bi-telephone-fill me-1"></i>No. Telepon</th>
                <th class="fw-bold text-center"><i class="bi bi-gear-fill me-1"></i>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($counselors as $index => $counselor)
                <tr>
                    <td class="text-center">{{ $counselors->firstItem() + $index }}</td>
                    <td>{{ $counselor->id_number }}</td>
                    <td>{{ $counselor->name }}</td>
                    <td>{{ $counselor->email }}</td>
                    <td>{{ $counselor->phone ?? '-' }}</td>
                    <td class="text-center">
                        {{-- Dropdown Aksi --}}
                        <div class="dropdown">
                            <a class="btn btn-light btn-sm rounded-circle shadow-sm border-0" style="font-size: 18px;" href="#" role="button" id="dropdownMenuLink{{ $counselor->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-three-dots-vertical"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink{{ $counselor->id }}">
                                @can('view-user')
                                    <a class="dropdown-item" href="{{ route('counselors.show', $counselor) }}">
                                        <i class="bi bi-eye me-2"></i>Detail
                                    </a>
                                @endcan
                                @can('edit-user')
                                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $counselor->id }}">
                                        <i class="bi bi-pencil me-2"></i>Edit
                                    </a>
                                @endcan
                                @can('delete-user')
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $counselor->id }}">
                                        <i class="bi bi-trash me-2"></i>Hapus
                                    </a>
                                @endcan
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
                            Tidak ada guru BK yang ditemukan dengan kata kunci: "<strong>{{ request('search') }}</strong>"
                        @else
                            Tidak ada data guru BK yang tersedia.
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
      <form action="{{ route('counselors.import') }}" method="POST" enctype="multipart/form-data" class="modal-content">
          @csrf
          <div class="modal-header">
              <h5 class="modal-title" id="importModalLabel">Import Data Guru BK</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <div class="mb-3">
                  <label for="file" class="form-label">Upload File (Excel .xlsx/.csv)</label>
                  <input type="file" class="form-control" name="file" accept=".csv, .xlsx" required>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-success">Import</button>
          </div>
      </form>
    </div>
  </div>
  

  @if($counselors->hasPages())
  <div class="d-flex justify-content-end align-items-center mt-4 flex-wrap gap-2">
      <nav>
          {{ $counselors->onEachSide(1)->links() }}
      </nav>
  </div>
@endif

@endsection
