@extends('layout.index')

@section('content')

<div class="container mt-5" style="font-family: 'Kumbh Sans';">
    <h2 class="fw-bold">Form Tambah Siswa</h2>

    <div class="mb-4">
        <a href="{{ route('students.index') }}" class="fw-bold btn btn-sm rounded-pill btn-glow">
            <i class="bi bi-caret-left-fill me-1"></i> Kembali
        </a>         
    </div>

    <form action="{{ route('students.store') }}" method="POST">
        @csrf

        <div class="card shadow-sm p-4 mb-5 bg-white rounded">
            
            <!-- Personal Information -->
            <h5 class="fw-bold mb-3">Data Siswa</h5>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nisn" class="form-label">NISN</label>
                    <input type="text" class="form-control" id="nisn" name="nisn" required>
                </div>
                <div class="col-md-6">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select class="form-control" id="kelas" name="kelas" required>
                        <option value="" disabled selected>Pilih Kelas</option>
                        <option value="7">Kelas 7</option>
                        <option value="8">Kelas 8</option>
                        <option value="9">Kelas 9</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="email_siswa" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email_siswa" name="email_siswa">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" required>
                </div>
                <div class="col-md-6">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="alamat_siswa" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat_siswa" name="alamat_siswa" required>
                </div>
                <div class="col-md-6">
                    <label for="telepon_siswa" class="form-label">No Telepon</label>
                    <input type="text" class="form-control" id="telepon_siswa" name="telepon_siswa">
                </div>
            </div>

            <hr class="my-4">

            <!-- Guardian Information -->
            <h5 class="fw-bold">Data Wali Murid</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="hubungan_wali" class="form-label">Hubungan</label>
                    <select class="form-select" id="hubungan_wali" name="hubungan_wali" required>
                        <option value="" disabled selected>Pilih Hubungan</option>
                        <option value="Ayah">Ayah</option>
                        <option value="Ibu">Ibu</option>
                        <option value="Wali Lainnya">Wali Lainnya</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="nama_wali" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" id="nama_wali" name="nama_wali" placeholder="Masukkan Nama Wali">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="telepon_wali" class="form-label">No Telepon</label>
                    <input type="text" class="form-control" id="telepon_wali" name="telepon_wali" placeholder="Masukkan No Telepon">
                </div>
                <div class="col-md-6">
                    <label for="email_wali" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email_wali" name="email_wali" placeholder="Masukkan Email">
                </div>
            </div>

            <div class="mb-3">
                <label for="alamat_wali" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat_wali" name="alamat_wali" placeholder="Masukkan Alamat">
            </div>


            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cancelModal">
                    Batal
                </button>
            </div>

        </div>
    </form>

    <!-- Modal Batal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="cancelModalLabel">Konfirmasi Batal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-start">
                    Apakah anda yakin untuk membatalkan editan?
                </div>
                <div class="modal-footer">
                    <a href="{{ route('students.index') }}" class="btn btn-danger">Yes</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection