<div class="modal fade" id="deletePresensiModal{{ $p->id }}" tabindex="-1" aria-labelledby="deletePresensiModalLabel{{ $p->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form action="{{ route('presensi.destroy', $p->id) }}" method="POST">
      @csrf
      @method('DELETE')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-danger">Hapus Presensi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          Apakah Anda yakin ingin menghapus presensi milik <strong>{{ $p->user->name }}</strong> pada tanggal <strong>{{ $p->tanggal_waktu }}</strong>?
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>
