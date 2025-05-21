<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal{{ $counseling->id }}" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel{{ $counseling->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="cancelModalLabel{{ $counseling->id }}">
                    Batalkan Konseling
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form action="{{ route('counseling.cancel', $counseling->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p class="text-start">Apakah anda yakin ingin membatalkan konseling ini?</p>
                    <div class="form-group mt-4 text-start">
                        <label for="cancel_notes" class="form-label fw-bold">Alasan Pembatalan</label>
                        <textarea name="notes" id="cancel_notes" rows="4" class="form-control" placeholder="Masukkan alasan pembatalan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>