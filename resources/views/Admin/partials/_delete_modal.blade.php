<div class="modal fade" id="deleteModal{{ $admin->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $admin->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-start">
                Apakah anda yakin ingin menghapus data admin ini?
            </div>
            <div class="modal-footer">
                <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div> 