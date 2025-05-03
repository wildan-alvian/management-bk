@extends('layout.index')

@section('content')
<div class="container mt-5" style="font-family: 'Kumbh Sans';">
    <h2 class="fw-bold mb-4">Detail Data Guru BK</h2>

    <div class="mb-4">
        <a href="{{ route('guru-bk.index') }}" class="fw-bold btn btn-sm rounded-pill btn-glow">
            <i class="bi bi-caret-left-fill me-1"></i> Kembali
        </a>         
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-lg p-4 mb-5 bg-light rounded">
        <h5 class="fw-bold mb-3">Data Guru BK</h5>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>NIP:</strong>
                    <p>{{ $guru->nip }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Nama:</strong>
                    <p>{{ $guru->nama }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Email:</strong>
                    <p>{{ $guru->email }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>No Telepon:</strong>
                    <p>{{ $guru->no_telepon }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card p-3 shadow-sm">
                    <strong>Alamat:</strong>
                    <p>{{ $guru->alamat }}</p>
                </div>
            </div>
        </div>

        <div class="mt-4 text-end">
            <a href="#" class="btn btn-warning btn-sm fw-bold me-2" data-bs-toggle="modal" data-bs-target="#editModal">
                <i class="bi bi-pencil-square me-1"></i> Edit
            </a>                           

            <button type="button" class="btn btn-danger btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                <i class="bi bi-trash-fill me-1"></i> Hapus
            </button>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editModalLabel">Edit Data Guru BK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <form action="{{ route('guru-bk.update', $guru->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" name="nip" id="nip" class="form-control" value="{{ $guru->nip }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" id="nama" class="form-control" value="{{ $guru->nama }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $guru->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_telepon" class="form-label">No Telepon</label>
                            <input type="text" name="no_telepon" id="no_telepon" class="form-control" value="{{ $guru->no_telepon }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ $guru->alamat }}</textarea>
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

    <!-- Modal Confirm Delete -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-start">
                    Apakah Anda yakin ingin menghapus data guru BK ini?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('guru-bk.destroy', $guru->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
