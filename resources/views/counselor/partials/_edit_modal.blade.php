<!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $counselor->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $counselor->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="editModalLabel{{ $counselor->id }}">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Guru BK
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('counselors.update', $counselor->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="nip" class="form-label fw-bold">NIP</label>
                            </div>
                            <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" 
                                   value="{{ $counselor->nip }}" required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="name" class="form-label fw-bold">Nama</label>
                            </div>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ $counselor->name }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="email" class="form-label fw-bold">Email</label>
                            </div>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                   value="{{ $counselor->email }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="phone" class="form-label fw-bold">No Telepon</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ $counselor->phone }}">
                            </div>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="text-start">
                                <label for="address" class="form-label fw-bold">Alamat</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
                                          rows="3">{{ $counselor->address }}</textarea>
                            </div>
                            @error('address')
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