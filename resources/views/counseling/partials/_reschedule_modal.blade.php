<!-- Reschedule Modal -->
<div class="modal fade" id="rescheduleModal{{ $counseling->id }}" tabindex="-1" aria-labelledby="rescheduleModalLabel{{ $counseling->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rescheduleModalLabel{{ $counseling->id }}">
                    <i class="bi bi-calendar-event me-2"></i>{{ $counseling->scheduled_at ? 'Reschedule' : 'Set Jadwal' }} Konseling
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('counseling.reschedule', $counseling->id) }}" method="POST">
                @csrf
                <div class="modal-body text-left">
                    <div class="mb-3">
                        <label for="current_scheduled_at" class="form-label fw-bold">Jadwal Sebelumnya</label>
                        <input type="text" class="form-control bg-light" id="current_scheduled_at" value="{{ $counseling->scheduled_at ? \Carbon\Carbon::parse($counseling->scheduled_at)->format('d M Y H:i') : 'Belum dijadwalkan' }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="scheduled_at" class="form-label fw-bold">{{ $counseling->scheduled_at ? 'Jadwal Baru' : 'Jadwal Konseling' }} <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror" id="scheduled_at" name="scheduled_at" required>
                        @error('scheduled_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="reschedule_reason" class="form-label fw-bold">{{ $counseling->scheduled_at ? 'Alasan Reschedule' : 'Catatan Tambahan' }} (Opsional)</label>
                        <textarea class="form-control @error('reschedule_reason') is-invalid @enderror" id="reschedule_reason" name="reschedule_reason" rows="3" placeholder="{{ $counseling->scheduled_at ? 'Berikan alasan mengapa Anda ingin mereschedule konseling ini...' : 'Berikan catatan tambahan untuk konseling ini...' }}"></textarea>
                        @error('reschedule_reason')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-calendar-check me-1"></i>{{ $counseling->scheduled_at ? 'Ajukan Reschedule' : 'Ajukan Jadwal' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#rescheduleModal{{ $counseling->id }} form');
    const scheduledAtInput = document.querySelector('#rescheduleModal{{ $counseling->id }} #scheduled_at');
    
    // Set minimum date to tomorrow
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    const tomorrowString = tomorrow.toISOString().slice(0, 16);
    scheduledAtInput.min = tomorrowString;
    
    form.addEventListener('submit', function(e) {
        const scheduledAt = new Date(scheduledAtInput.value);
        const now = new Date();
        
        if (scheduledAt <= now) {
            e.preventDefault();
            alert('Jadwal baru harus setelah waktu sekarang.');
            return false;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Memproses...';
        submitBtn.disabled = true;
        
        // Re-enable after 3 seconds if form doesn't submit
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
});
</script> 