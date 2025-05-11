    @extends('layout.index') 

    @section('content')
    <hr class="my-3"> 

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Daftar Admin</h4>
        <div class="d-flex">
            <form method="GET" action="{{ route('admin.index') }}" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-0" placeholder="Cari nama admin" style="max-width: 250px;">
                <button type="submit" class="btn btn-outline-secondary ms-0"><i class="bi bi-search"></i></button>
            </form>
            @if(request('search'))
                <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary ms-3"><i class="bi bi-x-circle-fill"></i></a>
            @endif
            <a href="{{ route('admin.create') }}" class="btn btn-orange text-white ms-3">+ Tambah Admin</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr>
                    <td>{{ $admins->firstItem() + $loop->index }}</td>
                    <td>{{ $admin->nip }}</td>
                    <td>{{ $admin->nama }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>
                        <a href="{{ route('admin.show', $admin->id) }}" class="btn btn-sm btn-link" style="font-size: 18px;">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a>                                    
                    </td>
                </tr>   
                @empty
                <tr>
                    <td colspan="5" class="text-muted">Tidak ada data admin yang tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Informasi jumlah dan pagination --}}

        <div class="d-flex justify-content-end mt-2">
            {{ $admins->withQueryString()->links('pagination::bootstrap-5') }}
        </div>    
    </div>

    @endsection
