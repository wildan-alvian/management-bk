<!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $counselor->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $counselor->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editModalLabel{{ $counselor->id }}">Edit Data Guru BK</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('counselors.update', $counselor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nip" class="form-label">NIP</label>
                        <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" 
                               value="{{ $counselor->nip }}" required>
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ $counselor->name }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ $counselor->email }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">No Telepon</label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ $counselor->phone }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
                                  rows="3">{{ $counselor->address }}</textarea>
                        @error('address')
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