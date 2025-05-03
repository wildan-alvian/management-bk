@extends('layout.index')

@section('content')
<div class="container mt-5" style="font-family: 'Kumbh Sans';">
    <div class="container">
        <div class="mb-3">
            <h2 class="fw-bold">Form Tambah Guru BK</h2>
        </div>
        <div class="mb-4">
            <a href="{{ route('guru-bk.index') }}" 
               class="fw-bold btn btn-sm rounded-pill btn-glow">
               <i class="bi bi-caret-left-fill me-1"></i> Kembali
            </a>         
        </div>

        <!-- Mulai Card -->
        <div class="card shadow-sm p-4 mb-5 bg-white rounded">
            <form action="{{ route('guru-bk.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" class="form-control" name="nip" required>
                    </div>
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="col-md-6">
                        <label for="no_telepon" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" name="no_telepon">
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-12">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="3"></textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cancelModal">
                        Batal
                    </button>
                </div>

            </form>
        </div>
        <!-- Selesai Card -->

        <!-- Modal Batal -->
        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title fw-bold" id="cancelModalLabel">Konfirmasi Batal</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                  Apakah anda yakin untuk membatalkan editan?
                </div>
                <div class="modal-footer">
                  <a href="{{ route('guru-bk.index') }}" class="btn btn-danger">Yes</a>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                </div>
              </div>
            </div>
        </div>

    </div>
</div>
@endsection
