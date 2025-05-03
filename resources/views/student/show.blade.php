@extends('layout.index')

@section('content')
<div class="container mt-5" style="font-family: 'Kumbh Sans';">
    <h2 class="fw-bold mb-4">Detail Data Siswa</h2>

    <div class="mb-4">
        <a href="{{ route('student.index') }}" class="fw-bold btn btn-sm rounded-pill btn-glow">
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
        <h5 class="fw-bold mb-3">Data Siswa</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>NISN:</strong>
                    <p>{{ $student->nisn }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Nama Lengkap:</strong>
                    <p>{{ $student->nama_lengkap }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Kelas:</strong>
                    <p>{{ $student->kelas }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Email:</strong>
                    <p>{{ $student->email_siswa }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Tempat Lahir:</strong>
                    <p>{{ $student->tempat_lahir }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Tanggal Lahir:</strong>
                    <p>{{ $student->tanggal_lahir }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Alamat:</strong>
                    <p>{{ $student->alamat_siswa }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>No Telepon:</strong>
                    <p>{{ $student->telepon_siswa }}</p>
                </div>
            </div>
        </div>

        <hr class="my-4">

        
        <h5 class="fw-bold mb-3">Data Wali Murid</h5>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Hubungan:</strong>
                    <p>{{ $student->hubungan_wali }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Nama Wali:</strong>
                    <p>{{ $student->nama_wali }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>No Telepon Wali:</strong>
                    <p>{{ $student->telepon_wali }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Email Wali:</strong>
                    <p>{{ $student->email_wali }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card p-3 shadow-sm">
                    <strong>Alamat Wali:</strong>
                    <p>{{ $student->alamat_wali }}</p>
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

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="editModalLabel">Edit Data Siswa dan Wali Murid</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <!-- Form Edit Siswa -->
                    <form action="{{ route('student.update', $student->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h6 class="fw-bold mb-3">Data Siswa</h6>
                        
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" value="{{ $student->nisn }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $student->nama_lengkap }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <select type="text" class="form-control" id="kelas" name="kelas" value="{{ $student->kelas }}" required>
                       <option value="" disabled selected>Pilih Kelas</option>
                                                    <option value="7">Kelas 7</option>
                                                    <option value="8">Kelas 8</option>
                                                    <option value="9">Kelas 9</option>
                                                </select>
                            </div>
                        <div class="mb-3">
                            <label for="email_siswa" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email_siswa" name="email_siswa" value="{{ $student->email_siswa }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $student->tempat_lahir }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ $student->tanggal_lahir }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_siswa" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat_siswa" name="alamat_siswa" value="{{ $student->alamat_siswa }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="telepon_siswa" class="form-label">No Telepon</label>
                            <input type="text" class="form-control" id="telepon_siswa" name="telepon_siswa" value="{{ $student->telepon_siswa }}" required>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h6 class="fw-bold mb-3">Data Wali Murid</h6>
                        
                        <div class="mb-3">
                            <label for="hubungan_wali" class="form-label">Hubungan</label>
                            <select type="text" class="form-control" id="hubungan_wali" name="hubungan_wali" value="{{ $student->hubungan_wali }}" required>
                                <option value="" disabled selected>Pilih Hubungan</option>
                                <option value="Ayah">Ayah</option>
                                <option value="Ibu">Ibu</option>
                                <option value="Wali Lainnya">Wali Lainnya</option>
                            </select>
                            </div>
                        <div class="mb-3">
                            <label for="nama_wali" class="form-label">Nama Wali</label>
                            <input type="text" class="form-control" id="nama_wali" name="nama_wali" value="{{ $student->nama_wali }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="telepon_wali" class="form-label">No Telepon Wali</label>
                            <input type="text" class="form-control" id="telepon_wali" name="telepon_wali" value="{{ $student->telepon_wali }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email_wali" class="form-label">Email Wali</label>
                            <input type="email" class="form-control" id="email_wali" name="email_wali" value="{{ $student->email_wali }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat_wali" class="form-label">Alamat Wali</label>
                            <input type="text" class="form-control" id="alamat_wali" name="alamat_wali" value="{{ $student->alamat_wali }}" required>
                        </div>
    
                        <div class="mt-3 text-end">
                            <button type="button" class="btn btn-secondary btn-sm fw-bold">tutup</button>
                            <button type="submit" class="btn btn-success btn-sm fw-bold">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-start">
                    Apakah anda yakin ingin menghapus data siswa ini?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('student.destroy', $student->id) }}" method="POST" class="d-inline">
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

<div class="card shadow-lg p-4 mb-5 bg-light rounded">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Data Prestasi</h4>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addAchievementModal">
                + Tambah Prestasi
            </button>
        </div>

@if($student->achievements->count())
<div class="table-responsive">
    <table class="table table-hover align-middle text-center">
        <thead class="table-light">
    <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Prestasi</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th></th> 
                </tr>
            </thead>
            <tbody>
                @foreach($student->achievements as $index => $achievement)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $achievement->name }}</td>
                        <td>{{ $achievement->category }}</td>
                        <td>{{ \Carbon\Carbon::parse($achievement->date)->format('d-m-Y') }}</td>
                        <td>{{ $achievement->detail ?? '-' }}</td>
                        <td>
                            
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editAchievementModal{{ $achievement->id }}">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </button>                            
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalAchievement{{ $achievement->id }}">
                                <i class="bi bi-trash me-1"></i> Hapus
                                </button>

                                <div class="modal fade" id="editAchievementModal{{ $achievement->id }}" tabindex="-1" aria-labelledby="editAchievementLabel{{ $achievement->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="editAchievementLabel{{ $achievement->id }}">Edit Prestasi</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                          <form action="{{ route('achievement.update', $achievement->id) }}" method="POST">
                                              @csrf
                                              @method('PUT')
                                              
                                              <div class="mb-3">
                                                  <label for="name{{ $achievement->id }}" class="form-label">Nama Prestasi</label>
                                                  <input type="text" class="form-control" id="name{{ $achievement->id }}" name="name" value="{{ $achievement->name }}" required>
                                              </div>
                                  
                                              <div class="mb-3">
                                                <label for="category{{ $achievement->id }}" class="form-label">Kategori</label>
                                                <select name="category" class="form-control" id="category{{ $achievement->id }}" onchange="toggleManualInput{{ $achievement->id }}()" required>
                                                    <option value="" disabled {{ $achievement->category == '' ? 'selected' : '' }}>Pilih Kategori</option>
                                                    <option value="Kecamatan" {{ $achievement->category == 'Kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                                                    <option value="Kabupaten" {{ $achievement->category == 'Kabupaten' ? 'selected' : '' }}>Kabupaten</option>
                                                    <option value="Provinsi" {{ $achievement->category == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
                                                    <option value="Nasional" {{ $achievement->category == 'Nasional' ? 'selected' : '' }}>Nasional</option>
                                                    <option value="Internasional" {{ $achievement->category == 'Internasional' ? 'selected' : '' }}>Internasional</option>
                                                    <option value="Lainnya" {{ !in_array($achievement->category, ['Kecamatan', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional']) ? 'selected' : '' }}>Lainnya (isi manual)</option>
                                                </select>
                                            </div>
                                            
                                            <!-- Input Manual -->
                                            <div id="manualInput{{ $achievement->id }}" style="{{ !in_array($achievement->category, ['Kecamatan', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional']) ? '' : 'display:none;' }}" class="mb-3">
                                                <input type="text" id="kategoriManual{{ $achievement->id }}" name="kategoriManual" class="form-control" placeholder="Masukkan pilihan lainnya" value="{{ !in_array($achievement->category, ['Kecamatan', 'Kabupaten', 'Provinsi', 'Nasional', 'Internasional']) ? $achievement->category : '' }}">
                                            </div>
                                  
                                              <div class="mb-3">
                                                  <label for="date{{ $achievement->id }}" class="form-label">Tanggal</label>
                                                  <input type="date" class="form-control" id="date{{ $achievement->id }}" name="date" value="{{ $achievement->date }}" required>
                                              </div>
                                  
                                              <div class="mb-3">
                                                  <label for="detail{{ $achievement->id }}" class="form-label">Keterangan</label>
                                                  <textarea class="form-control" id="detail{{ $achievement->id }}" name="detail">{{ $achievement->detail }}</textarea>
                                              </div>
                                  
                                              <div class="text-end">
                                                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
                                                  <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                              </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>                                  


<div class="modal fade" id="deleteModalAchievement{{ $achievement->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $achievement->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel{{ $achievement->id }}">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        Apakah anda yakin ingin menghapus data prestasi ini?
      </div>
      <div class="modal-footer">
        <form action="{{ route('achievement.destroy', $achievement->id) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Hapus</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </form>
      </div>
    </div>
  </div>
</div>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="text-muted mt-2">Belum ada data prestasi.</p>
@endif



<hr class="my-5">

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Data Pelanggaran</h5>
    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#addMisconductModal">
        + Tambah Pelanggaran
    </button>
</div>

@if($student->misconducts->count())
<div class="table-responsive">
    <table class="table table-hover align-middle text-center">
        <thead class="table-light">
    <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pelanggaran</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th></th> 
                </tr>
            </thead>
            <tbody>
                @foreach($student->misconducts as $index => $misconduct)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $misconduct->name }}</td>
                        <td>{{ $misconduct->category }}</td>
                        <td>{{ \Carbon\Carbon::parse($misconduct->date)->format('d-m-Y') }}</td>
                        <td>{{ $misconduct->detail ?? '-' }}</td>
                        <td>
                            
                            
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editMisconductModal{{ $misconduct->id }}">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </button>
                            
                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModalMisconduct{{ $misconduct->id }}">
                                <i class="bi bi-trash me-1"></i> Hapus
                            </button>

                            <div class="modal fade" id="editMisconductModal{{ $misconduct->id }}" tabindex="-1" aria-labelledby="editModalLabelMisconduct{{ $misconduct->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <form action="{{ route('misconduct.update', $misconduct->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabelMisconduct{{ $misconduct->id }}">Edit Pelanggaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                            
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Pelanggaran</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $misconduct->name }}" required>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="category" class="form-label">Kategori</label>
                                                    <select name="category" class="form-control" required>
                                                        <option value="Ringan" {{ $misconduct->category == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                                                        <option value="Berat" {{ $misconduct->category == 'Berat' ? 'selected' : '' }}>Berat</option>
                                                    </select>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="date" class="form-label">Tanggal</label>
                                                    <input type="date" name="date" class="form-control" value="{{ $misconduct->date }}" required>
                                                </div>
                            
                                                <div class="mb-3">
                                                    <label for="detail" class="form-label">Keterangan</label>
                                                    <input type="text" name="detail" class="form-control" value="{{ $misconduct->detail }}">
                                                </div>
                            
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            
                              
                            <div class="modal fade" id="deleteModalMisconduct{{ $misconduct->id }}" tabindex="-1" aria-labelledby="deleteModalLabelMisconduct{{ $misconduct->id }}" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabelMisconduct{{ $misconduct->id }}">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                  </div>
                                  <div class="modal-body">
                                    Apakah anda yakin ingin menghapus data pelanggaran ini?
                                  </div>
                                  <div class="modal-footer">
                                    <form action="{{ route('misconduct.destroy', $misconduct->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" class="btn btn-danger">Hapus</button>
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="text-muted mt-2">Belum ada data pelanggaran.</p>
@endif


<div class="modal fade" id="addAchievementModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('achievement.store') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Prestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="achievementFields">
                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" name="achievements[0][name]" class="form-control" placeholder="Nama Prestasi" required>
                        </div>
                        <div class="col-md-3">
                            <select name="achievements[0][category]" class="form-control" id="category" required onchange="toggleManualInput()">
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="Kecamatan">Kecamatan</option>
                                <option value="Kabupaten">Kabupaten</option>
                                <option value="Provinsi">Provinsi</option>
                                <option value="Nasional">Nasional</option>
                                <option value="Internasional">Internasional</option>
                                <option value="Lainnya">Lainnya (isi manual)</option>
                            </select>
                        </div>
                        
                        
                        <div id="manualInput" style="display:none;" class="col-md-3">
                            <input type="text" id="kategoriManual" name="kategoriManual" class="form-control" placeholder="Masukkan pilihan lainnya">
                        </div>

                        <div class="col-md-3">
                            <input type="date" name="achievements[0][date]" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="achievements[0][detail]" class="form-control" placeholder="Detail">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    @foreach($student->achievements as $achievement)
    function toggleManualInput{{ $achievement->id }}() {
        var category = document.getElementById("category{{ $achievement->id }}").value;
        var manualInput = document.getElementById("manualInput{{ $achievement->id }}");
        
        if (category === "Lainnya") {
            manualInput.style.display = "block";
        } else {
            manualInput.style.display = "none";
        }
    }
    @endforeach
    </script>
    
<script>
    function toggleManualInput() {
        var category = document.getElementById("category").value;
        var inputField = document.getElementById("manualInput");

        
        if (category === "Lainnya") {
            inputField.style.display = "block";
        } else {
            inputField.style.display = "none";
        }
    }
</script>



<div class="modal fade" id="addMisconductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('misconduct.store', ['studentId' => $student->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->id }}">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="misconductFields">
                  
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" name="misconducts[0][name]" class="form-control" placeholder="Nama Pelanggaran" required>
                        </div>
                        <div class="col-md-3">
                            <select name="misconducts[0][category]" class="form-control" placeholder="Kategori" required>
                            <option value="" disabled selected>Pilih Kategori</option>
        <option value="Ringan">Ringan</option>
        <option value="Berat">Berat</option>
    </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="misconducts[0][date]" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="misconducts[0][detail]" class="form-control" placeholder="Detail">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let achievementIndex = 1;
document.getElementById('addAchievementRow').addEventListener('click', function() {
    const container = document.getElementById('achievementFields');
    const newEntry = document.createElement('div');
    newEntry.classList.add('row', 'mb-3');
    newEntry.innerHTML = `
        <div class="col-md-3">
            <input type="text" name="achievements[${achievementIndex}][name]" class="form-control" placeholder="Nama Prestasi" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="achievements[${achievementIndex}][category]" class="form-control" placeholder="Kategori" required>
        </div>
        <div class="col-md-3">
            <input type="date" name="achievements[${achievementIndex}][date]" class="form-control" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="achievements[${achievementIndex}][detail]" class="form-control" placeholder="Detail">
        </div>`;
    container.appendChild(newEntry);
    achievementIndex++;
});

let misconductIndex = 1;
document.getElementById('addMisconductRow').addEventListener('click', function() {
    const container = document.getElementById('misconductFields');
    const newEntry = document.createElement('div');
    newEntry.classList.add('row', 'mb-3');
    newEntry.innerHTML = `
        <div class="col-md-3">
            <input type="text" name="misconducts[${misconductIndex}][name]" class="form-control" placeholder="Nama Pelanggaran" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="misconducts[${misconductIndex}][category]" class="form-control" placeholder="Kategori" required>
        </div>
        <div class="col-md-3">
            <input type="date" name="misconducts[${misconductIndex}][date]" class="form-control" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="misconducts[${misconductIndex}][detail]" class="form-control" placeholder="Detail">
        </div>`;
    container.appendChild(newEntry);
    misconductIndex++;
});
</script>
@endpush
@endsection
