<div class="modal fade" id="editPresensiModal{{ $p->id }}" tabindex="-1" aria-labelledby="editPresensiModalLabel{{ $p->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('presensi.update', $p->id) }}" method="POST" enctype="multipart/form-data" id="editPresensiForm{{ $p->id }}">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPresensiModalLabel{{ $p->id }}">Edit Presensi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>Status</label>
                <select class="form-select statusSelectEdit" name="status" data-id="{{ $p->id }}" required>
                    <option value="">Pilih Status</option>
                    <option value="hadir" {{ $p->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ $p->status == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="dispensasi" {{ $p->status == 'dispensasi' ? 'selected' : '' }}>Dispensasi</option>
                </select>
            </div>

            <!-- Section Kamera -->
            <div class="mb-3 d-none cameraSectionEdit" id="cameraSectionEdit{{ $p->id }}">
                <label>Foto Kehadiran</label>
                <video id="videoEdit{{ $p->id }}" width="100%" autoplay></video>
                <canvas id="canvasEdit{{ $p->id }}" class="d-none"></canvas>
                <input type="hidden" name="foto" id="fotoInputEdit{{ $p->id }}" value="{{ $p->foto ?? '' }}">

                <!-- Preview -->
                <div class="mt-2 d-none" id="previewSectionEdit{{ $p->id }}">
                    <label>Preview Foto</label><br>
                    <img id="fotoPreviewEdit{{ $p->id }}" class="img-fluid rounded border" alt="Hasil Foto">
                    <div class="mt-2">
                        <button type="button" class="btn btn-warning btn-sm ulangiBtnEdit" data-id="{{ $p->id }}">Ulangi Foto</button>
                    </div>
                </div>

                <!-- Foto lama -->
                @if($p->foto)
                    <div class="mt-2">
                        <small class="text-muted">Foto saat ini:</small><br>
                        <img src="{{ asset('storage/' . $p->foto) }}" alt="Foto" width="100px">
                    </div>
                @endif

                <button type="button" class="btn btn-success mt-2 captureBtnEdit" data-id="{{ $p->id }}">Ambil Foto</button>
            </div>

            <!-- Section Izin / Dispensasi -->
            <div class="mb-3 d-none descLampiranSectionEdit" id="descLampiranSectionEdit{{ $p->id }}">
                <label>Deskripsi</label>
                <textarea class="form-control" name="deskripsi">{{ $p->deskripsi }}</textarea>
                
                <label class="mt-2">Lampiran (PDF / Gambar)</label>
                <input type="file" name="lampiran" class="form-control" accept=".pdf,image/png,image/jpeg,image/jpg">

                @if($p->lampiran)
                    <div class="mt-1">
                        <small class="text-muted">File saat ini: </small>
                        @php
                            $ext = strtolower(pathinfo($p->lampiran, PATHINFO_EXTENSION));
                        @endphp

                        @if(in_array($ext, ['jpg','jpeg','png']))
                            <a href="{{ asset('storage/' . $p->lampiran) }}" target="_blank">
                                <img src="{{ asset('storage/' . $p->lampiran) }}" alt="Lampiran" width="100">
                            </a>
                        @elseif($ext === 'pdf')
                            <a href="{{ asset('storage/' . $p->lampiran) }}" target="_blank">{{ basename($p->lampiran) }}</a>
                        @else
                            <span>{{ basename($p->lampiran) }}</span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle section berdasarkan status
    function toggleEditSections(id) {
        const select = document.querySelector(`.statusSelectEdit[data-id='${id}']`);
        const status = select.value;
        const cameraSection = document.getElementById(`cameraSectionEdit${id}`);
        const descSection = document.getElementById(`descLampiranSectionEdit${id}`);

        if (status === 'hadir') {
            cameraSection.classList.remove('d-none');
            descSection.classList.add('d-none');
        } else if (status === 'izin' || status === 'dispensasi') {
            cameraSection.classList.add('d-none');
            descSection.classList.remove('d-none');
        } else {
            cameraSection.classList.add('d-none');
            descSection.classList.add('d-none');
        }
    }

    document.querySelectorAll('.statusSelectEdit').forEach(select => {
        const id = select.dataset.id;
        toggleEditSections(id);
        select.addEventListener('change', () => toggleEditSections(id));
    });

    // Kamera & Capture foto
    document.querySelectorAll('.captureBtnEdit').forEach(button => {
        const id = button.dataset.id;
        const video = document.getElementById(`videoEdit${id}`);
        const canvas = document.getElementById(`canvasEdit${id}`);
        const fotoInput = document.getElementById(`fotoInputEdit${id}`);
        const previewSection = document.getElementById(`previewSectionEdit${id}`);
        const fotoPreview = document.getElementById(`fotoPreviewEdit${id}`);

        let stream = null;

        // Mulai kamera saat modal dibuka
        $(`#editPresensiModal${id}`).on('shown.bs.modal', function () {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true }).then(s => {
                    stream = s;
                    video.srcObject = stream;
                    video.play();
                }).catch(() => alert("Kamera tidak bisa diakses!"));
            }
        });

        // Hentikan kamera saat modal ditutup
        $(`#editPresensiModal${id}`).on('hidden.bs.modal', function () {
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        });

        // Capture foto
        button.addEventListener('click', () => {
            if (!stream) return;

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

            const dataURL = canvas.toDataURL('image/png');
            fotoInput.value = dataURL;

            fotoPreview.src = dataURL;
            previewSection.classList.remove('d-none');
        });

        // Ulangi foto
        document.querySelector(`.ulangiBtnEdit[data-id='${id}']`).addEventListener('click', () => {
            fotoInput.value = "";
            previewSection.classList.add('d-none');
        });
    });
});
</script>
