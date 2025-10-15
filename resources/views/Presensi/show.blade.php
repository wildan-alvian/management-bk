@extends('layout.index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">
        <i class="bi bi-calendar-check me-2"></i> Detail Presensi
    </h4>
    <div>
        <a href="{{ route('presensi.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row g-4">
            <!-- Nama -->
            <div class="col-md-6">
                <div class="p-3 rounded bg-light">
                    <small class="text-muted d-block mb-1">
                        <i class="bi bi-person-badge me-1"></i> Nama Siswa
                    </small>
                    <span class="fw-semibold">{{ $presensi->user->name }}</span>
                </div>
            </div>

            <!-- Tanggal -->
            <div class="col-md-6">
                <div class="p-3 rounded bg-light">
                    <small class="text-muted d-block mb-1">
                        <i class="bi bi-calendar-date me-1"></i> Tanggal/Waktu
                    </small>
                    <span class="fw-semibold">
                        {{ \Carbon\Carbon::parse($presensi->tanggal_waktu)->format('d M Y, H:i') }}
                    </span>
                </div>
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <div class="p-3 rounded bg-light">
                    <small class="text-muted d-block mb-1">
                        <i class="bi bi-info-circle me-1"></i> Status
                    </small>
                    @php
                        $status = strtolower($presensi->status);
                        $badgeClass = match($status) {
                            'hadir' => 'success',
                            'terlambat' => 'danger',
                            'izin' => 'warning',
                            'dispensasi' => 'info',
                            default => 'secondary',
                        };
                    @endphp
                    <span class="badge bg-{{ $badgeClass }} px-3 py-2">
                        {{ ucfirst($presensi->status) }}
                    </span>
                </div>
            </div>

            <!-- Lampiran / Foto -->
            <div class="col-md-6">
                <div class="p-3 rounded bg-light">
                    <small class="text-muted d-block mb-1">
                        <i class="bi bi-paperclip me-1"></i> Lampiran / Foto
                    </small>

                    @if($presensi->lampiran)
                        @php
                            $extension = pathinfo($presensi->lampiran, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($extension), ['jpg','jpeg','png','gif','webp']);
                        @endphp

                        @if($isImage)
                            <img src="{{ asset('storage/' . $presensi->lampiran) }}" 
                                alt="Lampiran Presensi" 
                                class="img-thumbnail clickable-img" 
                                style="max-width: 180px;" 
                                data-bs-toggle="modal" 
                                data-bs-target="#imageModal" 
                                data-img="{{ asset('storage/' . $presensi->lampiran) }}">
                        @else
                            <a href="{{ asset('storage/' . $presensi->lampiran) }}" target="_blank" 
                            class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark-text me-1"></i> Lihat Lampiran
                            </a>
                        @endif
                    @elseif($presensi->foto)
                        <img src="{{ asset('storage/' . $presensi->foto) }}" 
                            alt="Foto Presensi" 
                            class="img-thumbnail clickable-img" 
                            style="max-width: 180px;" 
                            data-bs-toggle="modal" 
                            data-bs-target="#imageModal" 
                            data-img="{{ asset('storage/' . $presensi->foto) }}">
                    @else
                        <span class="text-muted fst-italic">Tidak ada lampiran</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Deskripsi (jika ada) -->
        @if(!empty($presensi->deskripsi))
        <div class="row g-3 mt-3">
            <div class="col-12">
                <div class="p-3 rounded bg-light">
                    <small class="text-muted d-block mb-1">
                        <i class="bi bi-card-text me-1"></i> Deskripsi
                    </small>
                    <span>{{ $presensi->deskripsi }}</span>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageModal = document.getElementById('imageModal');
    const previewImage = document.getElementById('previewImage');

    imageModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const imgSrc = button.getAttribute('data-img');
        previewImage.src = imgSrc;
    });

    imageModal.addEventListener('hidden.bs.modal', function () {
        previewImage.src = '';
    });
});
</script>
@endpush
@endsection
