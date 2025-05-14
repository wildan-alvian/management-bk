@extends('layout.index')

@section('content')
<div class="container mt-5" style="font-family: 'Kumbh Sans';">
    <div class="container">
        <div class="mb-3">
            <h2 class="fw-bold">Form Tambah Konseling</h2>
        </div>
        <div class="mb-4">
            <a href="{{ route('counseling.index') }}" 
               class="fw-bold btn btn-sm rounded-pill btn-glow">
               <i class="bi bi-caret-left-fill me-1"></i> Kembali
            </a>         
        </div>

        <form action="{{ route('counseling.store') }}" method="POST">
            @csrf

            <div class="card shadow-sm p-4 mb-5 bg-white rounded">
                    <form action="{{ route('counseling.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="scheduled_at" class="form-label fw-bold">Jadwal Konseling</label>
                                <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control" value="{{ old('scheduled_at') }}">
                            </div>                         

                            <div class="col-md-6">
                                <label for="counseling_type" class="form-label fw-bold">Tipe Konseling</label>
                                <select name="counseling_type" id="counseling_type" class="form-control">
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="siswa" {{ old('counseling_type') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                    <option value="wali_murid" {{ old('counseling_type') == 'wali_murid' ? 'selected' : '' }}>Wali Murid</option>
                                </select>
                            </div>
            
                            <div class="col-md-6">
                                <label for="title" class="form-label fw-bold">Judul Konseling</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Masukkan judul konseling" value="{{ old('title') }}">
                            </div>
                        </div>
            
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            
                <!-- Modal Konfirmasi Batal -->
                <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title fw-bold" id="cancelModalLabel">Konfirmasi Batal</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body text-start">
                          Apakah anda yakin ingin membatalkan pengisian form ini?
                        </div>
                        <div class="modal-footer">
                          <a href="{{ route('counseling.index') }}" class="btn btn-danger">Ya, Batalkan</a>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        </div>
                      </div>
                    </div>
                </div>
            
            </div>
            @endsection