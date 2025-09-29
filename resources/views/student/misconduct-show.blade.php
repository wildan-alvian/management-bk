@extends('layout.index')

@section('content')
<div class="container py-4">

    {{-- Header Judul & Tombol Aksi --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">
            <i class="bi bi-exclamation-circle me-2"></i> Detail Pelanggaran Siswa
        </h4>

        <div class="d-flex gap-2">
            @if(Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Guidance Counselor']))
                <a href="{{ route('misconducts.exportPdf', $misconduct->id) }}" class="btn btn-outline-danger">
                    <i class="bi bi-file-earmark-pdf me-1"></i>
                    Export PDF
                </a>
            @endif
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i></i>
                Kembali
            </a>
        </div>
    </div>


    {{-- Card Detail Pelanggaran --}}
<div class="card shadow border-0 rounded-4">
    <div class="card-body p-4">
        
        {{-- Informasi Utama --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="p-3 border rounded bg-light h-100">
                    <div class="d-flex align-items-center mb-2 text-muted small">
                        <i class="bi bi-flag me-2"></i> Nama Pelanggaran
                    </div>
                    <h6 class="fw-semibold mb-0">{{ $misconduct->name }}</h6>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 border rounded bg-light h-100">
                    <div class="d-flex align-items-center mb-2 text-muted small">
                        <i class="bi bi-tags me-2"></i> Kategori
                    </div>
                    <h6 class="fw-semibold mb-0">{{ $misconduct->category }}</h6>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 border rounded bg-light h-100">
                    <div class="d-flex align-items-center mb-2 text-muted small">
                        <i class="bi bi-calendar-date me-2"></i> Tanggal
                    </div>
                    <h6 class="fw-semibold mb-0">{{ \Carbon\Carbon::parse($misconduct->date)->translatedFormat('d F Y') }}</h6>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 border rounded bg-light h-100">
                    <div class="d-flex align-items-center mb-2 text-muted small">
                        <i class="bi bi-info-circle me-2"></i> Detail
                    </div>
                    <p class="mb-0">{{ $misconduct->detail }}</p>
                </div>
            </div>
            
            @if ($misconduct->file)
            <div class="col-md-12">
                <div class="p-3 border rounded bg-light d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center text-muted small">
                        <i class="bi bi-paperclip me-2"></i> Lampiran Pelanggaran
                    </div>
                    <a href="{{ Storage::url($misconduct->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-eye me-1"></i> Lihat File
                    </a>
                </div>
            </div>
            @endif
        </div>

        <hr class="my-4">

        {{-- Bagian Tindak Lanjut --}}
        <h6 class="fw-bold text-secondary mb-3 d-flex align-items-center">
            <i class="bi bi-journal-check me-2"></i> Tindak Lanjut
        </h6>

        @if($misconduct->followUp)
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="p-3 border rounded bg-light">
                        <div class="d-flex align-items-center mb-2 text-muted small">
                            <i class="bi bi-chat-left-text me-2"></i> Catatan
                        </div>
                        <p class="mb-0">{{ $misconduct->followUp->note }}</p>
                    </div>
                </div>
                @if($misconduct->followUp->file)
                <div class="col-md-12">
                    <div class="p-3 border rounded bg-light d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-paperclip me-2"></i> Lampiran Tindak Lanjut
                        </div>
                        <a href="{{ Storage::url($misconduct->followUp->file) }}" target="_blank" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-eye me-1"></i> Lihat File
                        </a>
                    </div>
                </div>
                @endif
            </div>
        @else
            <p class="text-muted fst-italic">Belum ada tindak lanjut yang tercatat.</p>
        @endif
    </div>
</div>
</div>
@endsection
