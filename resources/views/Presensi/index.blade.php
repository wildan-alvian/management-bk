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

    <form method="GET" action="{{ route('presensi.index') }}" class="d-flex" id="filterForm">
        <input type="text" name="search" value="{{ request('search') }}" 
               class="form-control me-2" placeholder="Cari nama atau status...">
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
            <th class="fw bold text-center" style="width: 5%;"></i>No</th>
            <th class="fw bold" style="width: 15%;"><i class="bi bi-person-badge me-2"></i>Nama</th>
            <th class="fw bold" style="width: 20%;"><i class="bi bi-clock-history me-2"></i>Tanggal/Waktu</th>
            <th class="fw bold" style="width: 15%;"><i class="bi bi-check2-circle me-2"></i>Status</th>
            <th class="fw bold" style="width: 20%;"><i class="bi bi-paperclip me-2"></i>Lampiran/Foto</th>
        @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor']))
            <th class="fw bold text-center" style="width: 10%;"><i class="bi bi-gear-fill me-2"></i> Aksi</th>
        @endif
        </tr>
    </thead>
    <tbody>
        @forelse($presensi as $index => $p)
        <tr>
            <td>{{ $presensi->firstItem() + $index }}</td>
            <td>{{ $p->user->name }}</td>
            <td>{{ $p->tanggal_waktu }}</td>
            <td>{{ ucfirst($p->status) }}</td>
            <td>
                @if($p->lampiran)
                    <a href="{{ asset('storage/' . $p->lampiran) }}" target="_blank">Lihat Lampiran</a>
                @elseif($p->foto)
                    <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto Presensi" width="100">
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
            <td colspan="6" class="text-center">Belum ada data presensi</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination -->
<div class="d-flex justify-content-center">
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
                <button type="button" class="btn btn-success mt-2" id="captureBtn">Ambil Foto</button>
            </div>

         <!-- Section Izin / Dispensasi -->
            <div class="mb-3 d-none" id="descLampiranSection">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi"></textarea>
                <label class="mt-2">Lampiran</label>
                <!-- Tambahkan accept agar hanya file tertentu (opsional) -->
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addPresensiModal = document.getElementById('addPresensiModal');
    let video = document.getElementById('video');
    let canvas = document.getElementById('canvas');
    let fotoInput = document.getElementById('fotoInput');
    let cameraSection = document.getElementById('cameraSection');
    let descLampiranSection = document.getElementById('descLampiranSection');
    let statusSelect = document.getElementById('statusSelect');
    let stream = null;

    // Saat modal ditampilkan
    addPresensiModal.addEventListener('shown.bs.modal', function () {
        cameraSection.classList.add('d-none');
        descLampiranSection.classList.add('d-none');
        fotoInput.value = '';
        stopCamera();
    });

    // Saat modal ditutup
    addPresensiModal.addEventListener('hidden.bs.modal', function () {
        stopCamera();
        fotoInput.value = '';
        statusSelect.value = '';
        cameraSection.classList.add('d-none');
        descLampiranSection.classList.add('d-none');
    });

    // Ganti status
    statusSelect.addEventListener('change', function() {
        console.log("Status dipilih:", this.value); // debug
        cameraSection.classList.add('d-none');
        descLampiranSection.classList.add('d-none');
        stopCamera();

        if (this.value === 'hadir') {
            cameraSection.classList.remove('d-none');
            startCamera();
        } else if (this.value === 'izin' || this.value === 'dispensasi') {
            descLampiranSection.classList.remove('d-none');
        }
    });

    // Capture foto
    document.getElementById('captureBtn').addEventListener('click', function() {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
        fotoInput.value = canvas.toDataURL('image/png');
        alert('Foto berhasil diambil!');
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
});
</script>
@endpush
