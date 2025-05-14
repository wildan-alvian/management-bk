<!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $counseling->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $counseling->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editModalLabel{{ $counseling->id }}">Edit Data Konseling</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('counseling.update', $counseling->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="scheduled_at" class="form-label">Jadwal Konseling</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="form-control @error('scheduled_at') is-invalid @enderror" 
                               value="{{ $counseling->scheduled_at }}" required>
                        @error('scheduled_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="submitted_by" class="form-label">Diajukan Oleh</label>
                        <input type="text" name="submitted_by" id="submitted_by" class="form-control @error('submitted_by') is-invalid @enderror" 
                               value="{{ $counseling->submitted_by }}" required>
                        @error('submitted_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="counseling_type" class="form-label">Tipe Konseling</label>
                        <select name="counseling_type" id="counseling_type" class="form-control @error('counseling_type') is-invalid @enderror">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="siswa" {{ $counseling->counseling_type == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="wali_murid" {{ $counseling->counseling_type == 'wali_murid' ? 'selected' : '' }}>Wali Murid</option>
                        </select>
                        @error('counseling_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Konseling</label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                               value="{{ $counseling->title }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">-- Pilih Status --</option>
                            <option value="new" {{ $counseling->status == 'new' ? 'selected' : '' }}>New</option>
                            <option value="approved" {{ $counseling->status == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $counseling->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div> 