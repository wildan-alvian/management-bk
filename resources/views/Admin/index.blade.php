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
