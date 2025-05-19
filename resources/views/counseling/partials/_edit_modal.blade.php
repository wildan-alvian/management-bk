<!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $counseling->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $counseling->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="editModalLabel{{ $counseling->id }}">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Konseling
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('counseling.update', $counseling->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="scheduled_at" class="form-label fw-bold">Jadwal Konseling</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                <input type="datetime-local" name="scheduled_at" id="scheduled_at" 
                                       class="form-control @error('scheduled_at') is-invalid @enderror" 
                                       value="{{ $counseling->scheduled_at }}" required>
                            </div>
                            @error('scheduled_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="submitted_by" class="form-label fw-bold">Diajukan Oleh</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="submitted_by" id="submitted_by" 
                                       class="form-control @error('submitted_by') is-invalid @enderror" 
                                       value="{{ $counseling->submitted_by }}" required>
                            </div>
                            @error('submitted_by')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="counseling_type" class="form-label fw-bold">Tipe Konseling</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                <select name="counseling_type" id="counseling_type" 
                                        class="form-select @error('counseling_type') is-invalid @enderror">
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="siswa" {{ $counseling->counseling_type == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                    <option value="wali_murid" {{ $counseling->counseling_type == 'wali_murid' ? 'selected' : '' }}>Wali Murid</option>
                                </select>
                            </div>
                            @error('counseling_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="title" class="form-label fw-bold">Judul Konseling</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-chat-left-text"></i></span>
                                <input type="text" name="title" id="title" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ $counseling->title }}">
                            </div>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="text-start">
                                <label for="status" class="form-label fw-bold">Status</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-check-circle"></i></span>
                                <select name="status" id="status" 
                                        class="form-select @error('status') is-invalid @enderror">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="new" {{ $counseling->status == 'new' ? 'selected' : '' }}>New</option>
                                    <option value="approved" {{ $counseling->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $counseling->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="canceled" {{ $counseling->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                </select>
                            </div>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 