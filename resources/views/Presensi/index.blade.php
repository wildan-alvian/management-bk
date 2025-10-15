@extends('layout.index')

@section('content')
<div class="row align-items-center mb-3 g-2">
    <div class="col-12 col-md-auto mb-2 mb-md-0">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-calendar-check me-2"></i>Daftar Presensi
        </h4>
    </div>
    <div class="col-12 col-md d-flex justify-content-md-end flex-wrap gap-2 mb-3">
         @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor']))
        <a href="{{ route('presensi.export') }}" class="btn btn-success">
             <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
         @endif

       <!-- Dropdown Filter Kelas sebagai Icon -->
<div class="d-flex align-items-center gap-2">

    <!-- Dropdown Filter Kelas -->
     @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor']))
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-filter me-1"></i>
        </button>
        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item {{ request('kelas') == '7' ? 'active' : '' }}" 
                   href="{{ route('presensi.index', array_merge(request()->all(), ['kelas' => '7'])) }}">
                   Kelas 7
                </a>
            </li>
            <li>
                <a class="dropdown-item {{ request('kelas') == '8' ? 'active' : '' }}" 
                   href="{{ route('presensi.index', array_merge(request()->all(), ['kelas' => '8'])) }}">
                   Kelas 8
                </a>
            </li>
            <li>
                <a class="dropdown-item {{ request('kelas') == '9' ? 'active' : '' }}" 
                   href="{{ route('presensi.index', array_merge(request()->all(), ['kelas' => '9'])) }}">
                   Kelas 9
                </a>
            </li>
        </ul>
    </div>

    <!-- Tombol Reset Filter di luar dropdown -->
    @if(request('kelas') || request('search'))
    <a href="{{ route('presensi.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
        <i class="bi bi-x-circle-fill"></i>
    </a>
    @endif
 @endif
</div>



    <form method="GET" action="{{ route('presensi.index') }}" class="d-flex" id="filterForm">
        <input type="text" name="search" value="{{ request('search') }}" 
               class="form-control me-2" placeholder="Cari nama, NISN, kelas, atau status...">
        <button type="submit" class="btn btn-outline-secondary me-2">
            <i class="bi bi-search"></i>
        </button>
    </form>
    @if(request('search'))
        <a href="{{ route('presensi.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-x-circle-fill"></i>
        </a>
    @endif

      @if(Auth::user()->hasRole(['Student']))
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPresensiModal">
        <i class="bi bi-plus-circle me-1"></i> Tambah Presensi
    </button>
      @endif
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {!! nl2br(e(session('success'))) !!}
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
            <th class="fw-bold text-center" style="width: 5%;">No</th>
            <th class="fw-bold"><i class="bi bi-card-text me-2"></i>NISN</th>
            <th class="fw-bold"><i class="bi bi-person-badge me-2"></i>Nama</th>
            <th class="fw-bold"><i class="bi bi-building me-2"></i>Kelas</th>
            <th class="fw-bold"><i class="bi bi-clock-history me-2"></i>Tanggal/Waktu</th>
            <th class="fw-bold"><i class="bi bi-check2-circle me-2"></i>Status</th>
            <th class="fw-bold"><i class="bi bi-paperclip me-2"></i>Lampiran/Foto</th>
        @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor']))
            <th class="fw bold text-center"><i class="bi bi-gear-fill"></i> Aksi</th>
        @endif
        </tr>
    </thead>
    <tbody>
        @forelse($presensi as $index => $p)
        <tr>
            <td>{{ $presensi->firstItem() + $index }}</td>
            <td>{{ $p->user->student->nisn ?? '-' }}</td>
            <td>{{ $p->user->name }}</td>
            <td>{{ $p->user->student->class ?? '-' }}</td>
            <td>{{ $p->tanggal_waktu }}</td>
            <td>
                @php
                    $status = strtolower($p->status);
                    $badgeClass = match($status) {
                        'hadir' => 'success',
                        'terlambat' => 'danger',
                        'izin' => 'warning',
                        'dispensasi' => 'info',
                        default => 'secondary',
                    };
                @endphp
                <span class="badge bg-{{ $badgeClass }} px-3 py-2">
                    {{ ucfirst($p->status) }}
                </span>
            </td>
            <td>
    @if($p->lampiran)
        @php
            $ext = strtolower(pathinfo($p->lampiran, PATHINFO_EXTENSION));
        @endphp
        @if(in_array($ext, ['jpg','jpeg','png','gif']))
            <img 
                src="{{ asset('storage/' . $p->lampiran) }}" 
                alt="Lampiran Foto" 
                width="100" 
                class="img-thumbnail clickable-img" 
                data-bs-toggle="modal" 
                data-bs-target="#imageModal" 
                data-img="{{ asset('storage/' . $p->lampiran) }}">
        @else
            <a href="{{ asset('storage/' . $p->lampiran) }}" target="_blank">Lihat Lampiran</a>
        @endif
    @elseif($p->foto)
        <img 
            src="{{ asset('storage/' . $p->foto) }}" 
            alt="Foto Presensi" 
            width="100" 
            class="img-thumbnail clickable-img" 
            data-bs-toggle="modal" 
            data-bs-target="#imageModal" 
            data-img="{{ asset('storage/' . $p->foto) }}">
    @else
        -
    @endif
        </td>

              @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor']))
            <td class="text-center">
            <div class="dropdown">
                <button class="btn btn-sm btn-light" type="button" id="dropdownMenuButton{{ $p->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $p->id }}">
                     <li>
                        <a href="{{ route('presensi.show', $p->id) }}" class="dropdown-item">
                            <i class="bi bi-eye-fill me-2"></i>Detail
                        </a>
                    </li>
                    <li>
                        <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editPresensiModal{{ $p->id }}">
                            <i class="bi bi-pencil-square me-2"></i>Edit
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deletePresensiModal{{ $p->id }}">
                            <i class="bi bi-trash3-fill me-2"></i>Hapus
                        </button>
                    </li>
                </ul>
            </div>
        </td>

        <!-- Include partial modal -->
        @include('presensi.partials.edit', ['p' => $p])
        @include('presensi.partials.delete', ['p' => $p])
        @endif
        @empty
        <tr>
            <td colspan="8" class="text-center">Belum ada data presensi</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-end">
    {{ $presensi->links() }}
</div>


<!-- Modal Tambah Presensi -->
<div class="modal fade" id="addPresensiModal" tabindex="-1" aria-labelledby="addPresensiModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('presensi.store') }}" method="POST" enctype="multipart/form-data" id="presensiForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPresensiModalLabel">Tambah Presensi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>Status</label>
                <select class="form-select" name="status" id="statusSelect" required>
                    <option value="">Pilih Status</option>
                    <option value="hadir">Hadir</option>
                    <option value="izin">Izin</option>
                    <option value="dispensasi">Dispensasi</option>
                </select>
            </div>

            <!-- Section Kamera -->
            <div class="mb-3 d-none" id="cameraSection">
                <label>Foto Kehadiran</label>
                <video id="video" width="100%" autoplay></video>
                <canvas id="canvas" class="d-none"></canvas>
                <input type="hidden" name="foto" id="fotoInput">

                <div class="mt-2">
                    <button type="button" class="btn btn-success" id="captureBtn">Ambil Foto</button>
                </div>

                <!-- Preview hasil jepretan -->
                <div class="mt-3 d-none" id="previewSection">
                    <label>Preview Foto</label><br>
                    <img id="fotoPreview" class="img-fluid rounded border" alt="Hasil Foto">
                    <div class="mt-2">
                        <button type="button" class="btn btn-warning btn-sm" id="ulangiBtn">Ulangi Foto</button>
                    </div>
                </div>
            </div>

            <!-- Section Izin / Dispensasi -->
            <div class="mb-3 d-none" id="descLampiranSection">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi"></textarea>
                <label class="mt-2">Lampiran</label>
                <input type="file" name="lampiran" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

<!-- Modal Preview Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0 shadow-none">
      <div class="modal-body text-center position-relative">
        <img id="previewImage" src="" alt="Preview Foto" class="img-fluid rounded shadow">
        <button type="button" class="btn btn-light position-absolute top-0 end-0 m-2" data-bs-dismiss="modal" aria-label="Close">
          <i class="bi bi-x-lg"></i>
        </button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<style>
  /* Supaya preview kamera tidak mirror */
  #video {
    transform: scaleX(-1);
  }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addPresensiModal = document.getElementById('addPresensiModal');
    let video = document.getElementById('video');
    let canvas = document.getElementById('canvas');
    let fotoInput = document.getElementById('fotoInput');
    let cameraSection = document.getElementById('cameraSection');
    let descLampiranSection = document.getElementById('descLampiranSection');
    let statusSelect = document.getElementById('statusSelect');
    let previewSection = document.getElementById('previewSection');
    let fotoPreview = document.getElementById('fotoPreview');
    let ulangiBtn = document.getElementById('ulangiBtn');
    let stream = null;

    addPresensiModal.addEventListener('shown.bs.modal', function () {
        resetForm();
    });

    addPresensiModal.addEventListener('hidden.bs.modal', function () {
        resetForm();
    });

    statusSelect.addEventListener('change', function() {
        cameraSection.classList.add('d-none');
        descLampiranSection.classList.add('d-none');
        previewSection.classList.add('d-none');
        fotoPreview.src = '';
        fotoInput.value = '';
        stopCamera();

        if (this.value === 'hadir') {
            cameraSection.classList.remove('d-none');
            startCamera();
        } else if (this.value === 'izin' || this.value === 'dispensasi') {
            descLampiranSection.classList.remove('d-none');
        }
    });

    // Capture foto (hasilnya tidak mirror)
    document.getElementById('captureBtn').addEventListener('click', function() {
        if (!stream) return;
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        let ctx = canvas.getContext('2d');
        ctx.save();
        ctx.translate(canvas.width, 0); // geser ke kanan
        ctx.scale(-1, 1); // balik horizontal
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        ctx.restore();
        let dataURL = canvas.toDataURL('image/png');
        fotoInput.value = dataURL;
        fotoPreview.src = dataURL;
        previewSection.classList.remove('d-none');
    });

    ulangiBtn.addEventListener('click', function() {
        fotoInput.value = '';
        fotoPreview.src = '';
        previewSection.classList.add('d-none');
    });

    function startCamera() {
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
            .then(s => {
                stream = s;
                video.srcObject = stream;
                video.play();
            })
            .catch(err => alert('Gagal mengakses kamera: ' + err));
        }
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
    }

    function resetForm() {
        stopCamera();
        fotoInput.value = '';
        statusSelect.value = '';
        cameraSection.classList.add('d-none');
        descLampiranSection.classList.add('d-none');
        previewSection.classList.add('d-none');
        fotoPreview.src = '';
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageModal = document.getElementById('imageModal');
    const previewImage = document.getElementById('previewImage');

    // Saat modal akan ditampilkan, ubah src gambar berdasarkan atribut data-img
    imageModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // elemen yang diklik
        const imgSrc = button.getAttribute('data-img');
        previewImage.src = imgSrc;
    });

    // Hapus src saat modal ditutup agar tidak terbebani memori
    imageModal.addEventListener('hidden.bs.modal', function () {
        previewImage.src = '';
    });
});
</script>

@endpush
