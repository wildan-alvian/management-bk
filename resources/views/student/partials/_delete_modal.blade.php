<!-- Modal Delete -->
<div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $student->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="deleteModalLabel{{ $student->id }}">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-start">
                Apakah Anda yakin ingin menghapus data siswa <strong>{{ $student->name }}</strong>?
                <div class="mt-2 text-danger">
                    <small><i class="bi bi-exclamation-triangle-fill me-1"></i>Tindakan ini juga akan menghapus data wali murid yang terkait.</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <form action="{{ route('students.destroy', $student->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> 