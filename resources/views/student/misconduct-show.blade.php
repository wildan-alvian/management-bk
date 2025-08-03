@extends('layout.index')

@section('content')
<div class="container py-4">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">
            <i class="bi bi-exclamation-circle me-2"></i>Detail Pelanggaran Siswa
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>Nama Pelanggaran:</strong> {{ $misconduct->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Kategori:</strong> {{ $misconduct->category }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($misconduct->date)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="col-md-12">
                    <p><strong>Detail:</strong> {{ $misconduct->detail }}</p>
                </div>
                @if ($misconduct->file)
                <div class="col-md-12 mb-3">
                    <p><strong>Lampiran Pelanggaran:</strong></p>
                    <a href="{{ Storage::url($misconduct->file) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-paperclip me-1"></i>Lihat File
                    </a>
                </div>
                @endif
            </div>

            <hr>

            <h6 class="fw-bold text-secondary mb-3">
                <i class="bi bi-journal-check me-2"></i>Tindak Lanjut
            </h6>

            @if($misconduct->followUp)
                <div class="mb-2">
                    <p><strong>Catatan:</strong> {{ $misconduct->followUp->note }}</p>
                </div>
                @if($misconduct->followUp->file)
                <div class="mb-2">
                    <p><strong>Lampiran Tindak Lanjut:</strong></p>
                    <a href="{{ Storage::url($misconduct->followUp->file) }}" target="_blank" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-paperclip me-1"></i>Lihat File
                    </a>
                </div>
                @endif
            @else
                <p class="text-muted fst-italic">Belum ada tindak lanjut yang tercatat.</p>
            @endif
        </div>
    </div>
</div>
@endsection
