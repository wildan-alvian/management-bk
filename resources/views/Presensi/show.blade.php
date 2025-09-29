@extends('layout.index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">
        <i class="bi bi-info-circle me-2"></i> Detail Presensi Siswa
    </h5>
    <div>
        <a href="{{ route('presensi.index') }}" class="btn btn-outline-secondary">
            <i></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row g-4">
            <!-- Baris 1 -->
            <div class="col-md-6">
                <div class="p-3 rounded bg-light">
                    <small class="text-muted d-block mb-1">
                        <i class="bi bi-person-badge me-1"></i> Nama Siswa
                    </small>
                    <span class="fw-semibold">{{ $presensi->user->name }}</span>
                </div>
            </div>
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

            <!-- Baris 2 sejajar -->
            <div class="row g-3 mb-3">
    {{-- Status --}}
    <div class="col-md-6">
        <div class="p-3 rounded bg-light">
            <small class="text-muted d-block mb-1">
                <i class="bi bi-info-circle me-1"></i> Status
            </small>
            <span class="fw-semibold">{{ ucfirst($presensi->status) }}</span>
        </div>
    </div>

    {{-- Lampiran --}}
    <div class="col-md-6">
        <div class="p-3 rounded bg-light">
            <small class="text-muted d-block mb-1">
                <i class="bi bi-paperclip me-1"></i> Lampiran
            </small>

            @if($presensi->lampiran)
                @php
                    $extension = pathinfo($presensi->lampiran, PATHINFO_EXTENSION);
                    $isImage = in_array(strtolower($extension), ['jpg','jpeg','png','gif','webp']);
                @endphp

                @if($isImage)
                    <img src="{{ asset('storage/' . $presensi->lampiran) }}" 
                         alt="Lampiran Presensi" 
                         class="img-thumbnail rounded shadow-sm" 
                         style="max-width: 180px;">
                @else
                    <a href="{{ asset('storage/' . $presensi->lampiran) }}" target="_blank" 
                       class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-file-earmark-text me-1"></i> Lihat Lampiran
                    </a>
                @endif
            @elseif($presensi->foto)
                <img src="{{ asset('storage/' . $presensi->foto) }}" 
                     alt="Foto Presensi" 
                     class="img-thumbnail rounded shadow-sm" 
                     style="max-width: 180px;">
            @else
                <span class="text-muted fst-italic">Tidak ada lampiran</span>
            @endif
        </div>
    </div>
</div>

{{-- Deskripsi (ditampilkan hanya jika ada) --}}
@if(!empty($presensi->deskripsi))
<div class="row g-3 mb-3">
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
</div>
@endsection
