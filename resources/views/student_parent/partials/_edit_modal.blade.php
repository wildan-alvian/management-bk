<!-- Modal Edit -->
<div class="modal fade" id="editModal{{ $studentParent->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $studentParent->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="editModalLabel{{ $studentParent->id }}">
                    <i class="bi bi-pencil-square me-2"></i>Edit Data Guru BK
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('student-parents.update', $studentParent->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="id_number" class="form-label fw-bold">NIK</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
                                <input type="text" name="id_number" id="id_number" class="form-control @error('id_number') is-invalid @enderror" 
                                       value="{{ $studentParent->id_number }}" required>
                            </div>
                            @error('id_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="name" class="form-label fw-bold">Nama</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ $studentParent->name }}" required>
                            </div>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="email" class="form-label fw-bold">Email</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope-at"></i></span>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ $studentParent->email }}" required>
                            </div>
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
                                       value="{{ $studentParent->phone }}">
                            </div>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="text-start">
                                <label for="family_relation" class="form-label fw-bold">Hubungan</label>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-diagram-2"></i></span>
                                <select class="form-select @error('family_relation') is-invalid @enderror" 
                                        id="family_relation" name="family_relation" required>
                                    <option value="">Pilih Hubungan</option>
                                    <option value="Ayah" {{ optional($studentParent->studentParent)->family_relation == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                                    <option value="Ibu" {{ optional($studentParent->studentParent)->family_relation == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                    <option value="Wali Lainnya" {{ optional($studentParent->studentParent)->family_relation == 'Wali Lainnya' ? 'selected' : '' }}>Wali Lainnya</option>
                                </select>
                            </div>
                            @error('family_relation')
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
                                          rows="3">{{ $studentParent->address }}</textarea>
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
