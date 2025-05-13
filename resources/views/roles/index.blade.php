@extends('layout.index') 

@section('content')
        <hr class="my-3"> 
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Daftar Roles</h4>
            <div class="d-flex">
                
                <form method="GET" action="{{ route('roles.index') }}" class="d-flex">
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control me-0" placeholder="Cari nama role" style="max-width: 250px;">
                    <button type="submit" class="btn btn-outline-secondary ms-0">
                        <i class="bi bi-search"></i> 
                    </button>
                </form>

                @if(isset($search))
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary ms-3">
                        <i class="bi bi-x-circle-fill"></i>
                    </a>
                @endif

                <a href="{{ route('roles.create') }}" class="btn btn-orange text-white ms-3">
                    + Tambah Role
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
                        <th class="text-center">No.</th>
                        <th>Nama</th>
                        <th>Hak akses</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td class="text-center">{{ $roles->firstItem() + $loop->index }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                @foreach($role->permissions as $permission)
                                    <span class="badge bg-info me-1">{{ $permission->name }}</span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @if($role->name !== 'Super Admin')
                                    <div class="dropdown">
                                        <a class="btn btn-sm btn-link" style="font-size: 18px;" href="#" role="button" id="dropdownMenuLink{{ $role->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $role->id }}">
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $role->id }}">Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $role->id }}">Delete</a>
                                        </div>                                
                                    </div>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal{{ $role->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $role->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title fw-bold" id="editModalLabel{{ $role->id }}">Edit Role</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">
                                    <div class="mb-3">
                                      <label for="name{{ $role->id }}" class="form-label">Nama</label>
                                      <input type="text" name="name" id="name{{ $role->id }}" class="form-control" value="{{ $role->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="permissions{{ $role->id }}" class="form-label">Hak akses</label>
                                        <select class="form-select select2" id="permissions{{ $role->id }}" name="permissions[]" multiple required>
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->id }}" {{ $role->permissions->contains($permission->id) ? 'selected' : '' }}>
                                                    {{ $permission->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                        </div>

                        <!-- Modal Delete -->
                        <div class="modal fade" id="deleteModal{{ $role->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $role->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="deleteModalLabel{{ $role->id }}">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body text-start">
                                        Apakah anda yakin ingin menghapus role ini?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                @if(isset($search))
                                    Tidak ada role yang ditemukan dengan kata kunci: "{{ $search }}"
                                @else
                                    Belum ada data role
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $roles->links() }}
        </div>
    </div>
</div>    

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('.modal'),
            placeholder: 'Pilih hak akses',
            allowClear: true
        });
    });
</script>
@endpush

@endsection
