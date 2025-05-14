<!-- Modal Delete -->
<div class="modal fade" id="deleteModal{{ $counseling->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $counseling->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="deleteModalLabel{{ $counseling->id }}">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-start">
                Apakah anda yakin ingin menghapus data konseling ini?
            </div>
            <div class="modal-footer">
                <form action="{{ route('counseling.destroy', $counseling->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div> 