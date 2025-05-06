@extends('layout.index') 

@section('content')
<div class="container mt-5" style="font-family: 'Kumbh Sans';">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="dropdown">
                <a class="d-flex align-items-center text-decoration-none dropdown-toggle" style="gap: 1rem;" href="#" role="button" id="dropdownProfile" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('asset/images/profile.png') }}" alt="Foto Profil" class="rounded-circle me-2" width="45" height="45">
                    <div class="text-start">
                        <h5 class="mb-0 fw-bold text-dark">{{ Auth::user()->nama_lengkap ?? 'M. Wildan Alvian Prastya' }}</h5>
                        <small class="text-muted">Administrator</small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-animated" aria-labelledby="dropdownProfile">
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <i class="bi bi-pencil-square"></i> Edit Profil
                        </a>                        
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>            
        </div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip" value="{{ Auth::user()->nip }}">
                        </div>
                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ Auth::user()->nama_lengkap }}">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}">
                        </div>
                        <div class="col-md-6">
                            <label for="telepon" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" value="{{ Auth::user()->telepon }}">
                        </div>
                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3">{{ Auth::user()->alamat }}</textarea>
                        </div>
                        <div class="col-12">
                            <label for="foto" class="form-label">Foto Profil</label><br>
                            <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('asset/images/profile.png') }}" alt="Foto Profil" class="mb-2 rounded" width="80">
                            <input class="form-control" type="file" id="foto" name="foto">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

        <hr class="my-3"> 
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">Daftar Admin</h4>
            <div class="d-flex">
                
                <form method="GET" action="{{ route('admin.index') }}" class="d-flex">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control me-0" placeholder="Cari nama admin" style="max-width: 250px;">
                    <button type="submit" class="btn btn-outline-secondary ms-0">
                        <i class="bi bi-search"></i> 
                    </button>
                </form>

                @if(request('search'))
                <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary ms-3"> <i class="bi bi-x-circle-fill"></i>
                @endif

    
                <a href="{{ route('admin.create') }}" class="btn btn-orange text-white ms-3">
                    + Tambah Admin
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead class="table-light">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $admin->nip }}</td>
                            <td>{{ $admin->nama }}</td>
                            <td>{{ $admin->email }}</td>
                            <td>
                                <div class="d-flex">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('admin.show', $admin->id) }}" class="btn btn-sm btn-link" style="font-size: 18px;">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </a>                                    
                                </div>
                            </td>
                        </tr>   
                    @endforeach 
                </tbody>
            </table>
        </div>

        
        <div class="d-flex justify-content-end mt-3">
            {{ $admins->links() }}
        </div>
    </div>
</div>
@endsection
