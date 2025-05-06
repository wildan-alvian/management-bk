@extends('layout.index') 

@section('content')
<div class="container mt-5" style="font-family: 'Kumbh Sans';">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex align-items-center">
                <img src="{{ asset('asset/images/profile.png') }}" alt="Foto Profil" class="rounded-circle me-3" width="45" height="45">
                <div>
                    <h5 class="mb-0 fw-bold">M. Wildan Alvian Prastya</h5>
                    <small class="text-muted">Administrator</small>
                </div>
            </div>
        </div>
        <hr class="my-3"> 
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Daftar Roles</h4>
            <div class="d-flex">
                
                <form method="GET" action="{{ route('roles.index') }}" class="d-flex">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control me-0" placeholder="Cari nama admin" style="max-width: 250px;">
                    <button type="submit" class="btn btn-outline-secondary ms-0">
                        <i class="bi bi-search"></i> 
                    </button>
                </form>

                @if(request('search'))
                <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary ms-3"> <i class="bi bi-x-circle-fill"></i>
                @endif

    
                <a href="{{ route('roles.create') }}" class="btn btn-orange text-white ms-3">
                    + Tambah Role
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Hak akses</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->permission }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-sm btn-link" style="font-size: 18px;" href="#" role="button" id="dropdownMenuLink1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editModal">Edit</a>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</a>
                                    </div>                                
                                </div>
                            </td>
                        </tr>
                        <!-- Modal Edit -->
                        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title fw-bold" id="editModalLabel">Edit Role</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <form action="{{ route('roles.update', $role->id) }}" method="POST">
                                  @csrf
                                  @method('PUT')
                                  <div class="modal-body">
                                    <div class="mb-3">
                                      <label for="nama" class="form-label">Nama</label>
                                      <input type="text" name="nama" id="nama" class="form-control" value="{{ $role->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="permission" class="form-label">Hak akses</label>
                                        <select class="form-control" id="permission" name="permission" required>
                                            @forelse ($permissions as $permission)
                                                    <option value="{{ $permission->id }}" {{ in_array($permission->id, $rolePermissions ?? []) ? 'selected' : '' }}>
                                                        {{ $permission->name }}
                                                    </option>
                                                @empty
                                            @endforelse
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
                        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
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
                    @endforeach 
                </tbody>
            </table>
        </div>

        
        <div class="d-flex justify-content-end mt-3">
            {{ $roles->links() }}
        </div>
    </div>
</div>    
@endsection
