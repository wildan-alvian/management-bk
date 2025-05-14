<!-- Achievement Modal -->
<div class="modal fade" id="achievementModal" tabindex="-1" aria-labelledby="achievementModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="achievementModalLabel">Tambah Prestasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="achievementForm">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->student->id }}">
                <input type="hidden" name="achievement_id" id="achievement_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="text-start">
                            <label for="name" class="form-label fw-bold">Nama Prestasi</label>
                        </div>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback" id="name-error"></div>
                    </div>
                    <div class="mb-3">
                        <div class="text-start">
                            <label for="category" class="form-label fw-bold">Kategori</label>
                        </div>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Akademik">Akademik</option>
                            <option value="Non-Akademik">Non-Akademik</option>
                            <option value="Olahraga">Olahraga</option>
                            <option value="Seni">Seni</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <div class="invalid-feedback" id="category-error"></div>
                    </div>
                    <div class="mb-3">
                        <div class="text-start">
                            <label for="date" class="form-label fw-bold">Tanggal</label>
                        </div>
                        <input type="date" class="form-control" id="date" name="date" required>
                        <div class="invalid-feedback" id="date-error"></div>
                    </div>
                    <div class="mb-3">
                        <div class="text-start">
                            <label for="detail" class="form-label fw-bold">Detail</label>
                        </div>
                        <textarea class="form-control" id="detail" name="detail" rows="3" required></textarea>
                        <div class="invalid-feedback" id="detail-error"></div>
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

@push('scripts')
<script>
$(document).ready(function() {
    // Reset form and errors when modal is closed
    $('#achievementModal').on('hidden.bs.modal', function() {
        $('#achievementForm')[0].reset();
        $('#achievement_id').val('');
        $('#achievementModalLabel').text('Tambah Prestasi');
        clearErrors();
    });

    // Handle form submission
    $('#achievementForm').on('submit', function(e) {
        e.preventDefault();
        clearErrors();

        const formData = new FormData(this);
        const achievementId = $('#achievement_id').val();
        
        let url = "{{ route('student-achievements.store') }}";
        let method = 'POST';
        
        if (achievementId) {
            url = "{{ url('student-achievements') }}/" + achievementId;
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            method: method,
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Update or add row
                    if (achievementId) {
                        updateAchievementRow(response.data);
                    } else {
                        addAchievementRow(response.data);
                    }

                    // Close modal and show success message
                    $('#achievementModal').modal('hide');
                    $('#achievementForm')[0].reset();
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(field => {
                        $(`#${field}`).addClass('is-invalid');
                        $(`#${field}-error`).text(errors[field][0]);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat menyimpan data'
                    });
                }
            }
        });
    });

    // Handle edit button click
    $(document).on('click', '.edit-achievement', function() {
        clearErrors();
        const button = $(this);
        const id = button.data('id');
        const name = button.data('name');
        const category = button.data('category');
        const fullDate = button.data('date');
        const detail = button.data('detail');
        
        const date = fullDate.split(' ')[0];

        $('#achievement_id').val(id);
        $('#name').val(name);
        $('#category').val(category);
        $('#date').val(date);
        $('#detail').val(detail);

        $('#achievementModalLabel').text('Edit Prestasi');
        $('#achievementModal').modal('show');
    });

    // Handle delete button click
    $(document).on('click', '.delete-achievement', function() {
        const id = $(this).data('id');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data prestasi akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('student-achievements') }}/" + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });

                            $(`#achievement-${id}`).remove();
                            
                            // Check if there are any remaining rows except the "no data" row
                            const remainingRows = $('#achievementsTable tbody tr:not(#no-achievements)').length;
                            
                            if (remainingRows === 0) {
                                $('#achievementsTable tbody').html(`
                                    <tr id="no-achievements">
                                        <td colspan="6" class="text-center">Tidak ada data prestasi</td>
                                    </tr>
                                `);
                            } else {
                                // Reorder remaining rows
                                $('#achievementsTable tbody tr:not(#no-achievements)').each(function(index) {
                                    $(this).find('td:first').text(index + 1);
                                });
                            }
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menghapus data',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    });

    // Helper function to add new achievement row
    function addAchievementRow(achievement) {
        const rowCount = $('#achievementsTable tbody tr:not(#no-achievements)').length;
        const newRow = createAchievementRow(achievement, rowCount);
        
        if ($('#no-achievements').length) {
            $('#no-achievements').remove();
        }
        
        $('#achievementsTable tbody').append(newRow);
    }

    // Helper function to update existing achievement row
    function updateAchievementRow(achievement) {
        const row = $(`#achievement-${achievement.id}`);
        const rowIndex = row.index();
        const newRow = createAchievementRow(achievement, rowIndex);
        row.replaceWith(newRow);
    }

    // Helper function to create achievement row HTML
    function createAchievementRow(achievement, index) {
        const date = new Date(achievement.date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

        const canEdit = {{ auth()->user()->can('edit-student') ? 'true' : 'false' }};
        
        let actionsHtml = '';
        if (canEdit) {
            actionsHtml = `
                <button type="button" class="btn btn-warning btn-sm edit-achievement"
                    data-id="${achievement.id}"
                    data-name="${achievement.name}"
                    data-category="${achievement.category}"
                    data-date="${achievement.date}"
                    data-detail="${achievement.detail}">
                    <i class="bi bi-pencil-square"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm delete-achievement" data-id="${achievement.id}">
                    <i class="bi bi-trash"></i>
                </button>
            `;
        }

        return `
            <tr id="achievement-${achievement.id}">
                <td>${index + 1}</td>
                <td>${achievement.name}</td>
                <td>${achievement.category}</td>
                <td>${date}</td>
                <td>${achievement.detail}</td>
                <td>${actionsHtml}</td>
            </tr>
        `;
    }

    // Helper function to clear form errors
    function clearErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    }
});
</script>
@endpush 