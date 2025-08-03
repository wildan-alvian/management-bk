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
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="fw-bold">Detail Konseling</h3>
                    <a href="{{ route('counseling.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Judul Konseling</label>
                                <input type="text" class="form-control" value="{{ $counseling->title }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tipe Konseling</label>
                                <input type="text" class="form-control" value="{{ $counseling->counseling_type }}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Diajukan Oleh</label>
                                <input type="text" class="form-control" value="{{ $counseling->submittedByUser->name }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Tanggal & Waktu Konseling</label>
                                <input type="text" class="form-control" value="{{ $counseling->scheduled_at->format('d F Y H:i') }}" disabled>
                                @if($counseling->old_date)
                                <small class="text-muted">Rescheduled dari: {{ $counseling->old_date->format('d F Y H:i') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea class="form-control" rows="4" disabled>{{ $counseling->description }}</textarea>
                        </div>

                        @if($counseling->status !== 'new' && $counseling->notes)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Catatan</label>
                            <textarea class="form-control" rows="4" disabled>{{ $counseling->notes }}</textarea>
                        </div>
                        @endif

                        @if($counseling->reschedule_note)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Alasan Reschedule</label>
                            <textarea class="form-control" rows="3" disabled>{{ $counseling->reschedule_note }}</textarea>
                        </div>
                        @endif

                        <div class="mb-3">
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

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold fs-5">
                       </i> Tindak Lanjut Konseling
                    </h5>

                    @hasanyrole('Admin|Super Admin|Guidance Counselor')
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Tindak Lanjut
                    </button>
                    @endhasanyrole
                </div>
            
               <div class="table-responsive" style="min-height: fit-content">
                    <table class="table table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">No</th>
                                <th>Deskripsi</th>
                                <th style="width: 160px;">Tanggal</th>
                                @hasanyrole('Admin|Super Admin|Guidance Counselor')
                                <th style="width: 150px;">Aksi</th>
                                @endhasanyrole
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(optional($counseling)->tindaklanjuts ?? [] as $key => $tindaklanjut)
                            <tr>
                                <td class="fw-semibold">{{ $key + 1 }}</td>
                                <td class="text-start text-secondary">{{ $tindaklanjut->description }}</td>
                                <td>{{ \Carbon\Carbon::parse($tindaklanjut->tanggal ?? $tindaklanjut->created_at)->format('d F Y') }}</td>
                                <td>
                                    @hasanyrole('Admin|Super Admin|Guidance Counselor')
                                    <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $tindaklanjut->id }}" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalHapus{{ $tindaklanjut->id }}" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    @endhasanyrole
                                </td>
                            </tr>
                            <tr>
            
                           {{-- Modal Edit --}}
                            <div class="modal fade" id="modalEdit{{ $tindaklanjut->id }}" tabindex="-1" aria-labelledby="modalEditLabel{{ $tindaklanjut->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('tindaklanjut.update', $tindaklanjut->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content border-0 shadow rounded-3">
                                            <div class="modal-header border-bottom-0 pt-4 px-4">
                                                <h5 class="modal-title fw-semibold" id="modalEditLabel{{ $tindaklanjut->id }}">Edit Tindak Lanjut</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body px-4 pt-0 pb-3">
                                                <div class="mb-3">
                                                    <label for="description{{ $tindaklanjut->id }}" class="form-label fw-medium">Deskripsi</label>
                                                    <textarea name="description" id="description{{ $tindaklanjut->id }}" class="form-control" rows="3" required>{{ old('description', $tindaklanjut->description) }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tanggal{{ $tindaklanjut->id }}" class="form-label fw-medium">Tanggal</label>
                                                    <input type="date" name="tanggal" id="tanggal{{ $tindaklanjut->id }}" class="form-control" value="{{ $tindaklanjut->tanggal ?? $tindaklanjut->created_at->format('Y-m-d') }}" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top-0 px-4 pb-4 d-flex justify-content-end gap-2">
                                                <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                                                    <i class="bi bi-x-circle me-1"></i> Batal
                                                </button>
                                                <button type="submit" class="btn btn-primary px-4">
                                                    <i class="bi bi-check-circle me-1"></i> Simpan
                                                </button>
                                            </div>                                            
                                        </div>
                                    </form>
                                </div>
                            </div>

                            {{-- Modal Hapus --}}
                            <div class="modal fade" id="modalHapus{{ $tindaklanjut->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('tindaklanjut.destroy', $tindaklanjut->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Hapus Tindak Lanjut</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="fs-6">Apakah Anda yakin ingin menghapus tindak lanjut ini?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted fs-6">Belum ada data tindak lanjut.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            
            {{-- Modal Tambah --}}
            <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('tindaklanjut.store', ['id' => $counseling->id]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="counseling_id" value="{{ $counseling->id }}">
                        <div class="modal-content">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title" id="modalTambahLabel">Tambah Tindak Lanjut</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Deskripsi</label>
                                    <textarea name="description" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold"><i class="bi bi-check-circle me-2"></i>Setujui Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('counseling.approve', $counseling->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label for="notes" class="form-label fw-bold">Catatan Meeting</label>
                    <textarea name="notes" id="notes" rows="4" class="form-control" placeholder="Masukkan link meeting dan catatan tambahan..."></textarea>
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
                <h5 class="modal-title fw-bold">Tolak Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('counseling.reject', $counseling->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <label for="reject_notes" class="form-label fw-bold">Alasan Penolakan</label>
                    <textarea name="notes" id="reject_notes" rows="4" class="form-control" placeholder="Masukkan alasan penolakan..."></textarea>
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