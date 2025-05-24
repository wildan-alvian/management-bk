@extends('layout.index')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="fw-bold">Detail Konseling</h3>
                        <a href="{{ route('counseling.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="form-label fw-bold">Judul Konseling</label>
                                    <input type="text" class="form-control" id="title" value="{{ $counseling->title }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="counseling_type" class="form-label fw-bold">Tipe Konseling</label>
                                    <input type="text" class="form-control" id="counseling_type" value="{{ $counseling->counseling_type }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="submitted_by" class="form-label fw-bold">Diajukan Oleh</label>
                                    <input type="text" class="form-control" id="submitted_by" value="{{ $counseling->submittedByUser->name }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="scheduled_at" class="form-label fw-bold">Tanggal & Waktu Konseling</label>
                                    <input type="text" class="form-control" id="scheduled_at" value="{{ $counseling->scheduled_at->format('d F Y H:i') }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description" class="form-label fw-bold">Deskripsi</label>
                            <textarea class="form-control" id="description" rows="4" disabled>{{ $counseling->description }}</textarea>
                        </div>

                        @if($counseling->status !== 'new' && $counseling->notes)
                        <div class="form-group mb-3">
                            <label for="notes" class="form-label fw-bold">Catatan</label>
                            <textarea class="form-control" id="notes" rows="4" disabled>{{ $counseling->notes }}</textarea>
                        </div>
                        @endif

                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Status</label>
                            @php
                                $statusColors = [
                                    'new' => 'bg-warning text-white',
                                    'approved' => 'bg-success text-white',
                                    'rejected' => 'bg-danger text-white',
                                    'canceled' => 'bg-secondary text-white'
                                ];
                                $statusLabels = [
                                    'new' => 'Baru',
                                    'approved' => 'Disetujui',
                                    'rejected' => 'Ditolak',
                                    'canceled' => 'Dibatalkan'
                                ];
                            @endphp
                            <div>
                                <span class="badge rounded-pill {{ $statusColors[$counseling->status] }} px-3 py-2">
                                    {{ $statusLabels[$counseling->status] }}
                                </span>
                            </div>
                        </div>

                        @if($counseling->status === 'new' && auth()->user()->hasRole('Guidance Counselor'))
                        <div class="d-flex justify-content-end">
                            <button type="button" onclick="openRejectModal()" class="btn btn-danger me-2">
                                <i class="bi bi-x-circle me-1"></i>Tolak
                            </button>
                            <button type="button" onclick="openApproveModal()" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Setujui
                            </button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="editModalLabel{{ $counseling->id }}">
                    <i class="bi bi-check-circle me-2"></i>Setujui Konseling
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('counseling.approve', $counseling->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="notes" class="form-label fw-bold">Catatan Meeting</label>
                        <textarea name="notes" id="notes" rows="4" class="form-control" placeholder="Masukkan link meeting dan catatan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="editModalLabel{{ $counseling->id }}">
                    Tolak Konseling
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('counseling.reject', $counseling->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="reject_notes" class="form-label fw-bold">Alasan Penolakan</label>
                        <textarea name="notes" id="reject_notes" rows="4" class="form-control" placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openApproveModal() {
        $('#approveModal').modal('show');
    }

    function closeApproveModal() {
        $('#approveModal').modal('hide');
    }

    function openRejectModal() {
        $('#rejectModal').modal('show');
    }

    function closeRejectModal() {
        $('#rejectModal').modal('hide');
    }
</script>
@endpush 