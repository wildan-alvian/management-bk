<!-- Misconduct Modal -->
<div class="modal fade" id="misconductModal" tabindex="-1" aria-labelledby="misconductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold" id="misconductModalLabel">Tambah Pelanggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="misconductForm">
                @csrf
                <input type="hidden" name="student_id" value="{{ $student->student->id }}">
                <input type="hidden" name="misconduct_id" id="misconduct_id">
                <div class="modal-body">
                    <!-- Existing fields -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="misconduct_name" class="form-label fw-bold">Nama Pelanggaran</label>
                                <input type="text" class="form-control" id="misconduct_name" name="name" required>
                                <div class="invalid-feedback" id="misconduct-name-error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="misconduct_category" class="form-label fw-bold">Kategori</label>
                                <select class="form-select" id="misconduct_category" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                </select>
                                <div class="invalid-feedback" id="misconduct-category-error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="misconduct_date" class="form-label fw-bold">Tanggal</label>
                                <input type="date" class="form-control" id="misconduct_date" name="date" required>
                                <div class="invalid-feedback" id="misconduct-date-error"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="misconduct_file" class="form-label fw-bold">File Pelanggaran (opsional)</label>
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control" id="misconduct_file" name="file" accept=".png,.jpg,.jpeg,.pdf">
                                    <div id="misconduct-file-action-icons" class="ms-2"></div>
                                </div>
                                <div class="invalid-feedback" id="misconduct-file-error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="misconduct_detail" class="form-label fw-bold">Detail</label>
                        <textarea class="form-control" id="misconduct_detail" name="detail" rows="3" required></textarea>
                        <div class="invalid-feedback" id="misconduct-detail-error"></div>
                    </div>

                    <!-- TINDAK LANJUT SECTION -->
                    <hr>
                    <h6 class="fw-bold">Tindak Lanjut</h6>
                    <div class="mb-3">
                        <label for="followup_notes" class="form-label fw-bold">Catatan</label>
                        <textarea class="form-control" id="followup_notes" name="followup_notes" rows="3"></textarea>
                        <div class="invalid-feedback" id="followup-notes-error"></div>
                    </div>
                    <div class="mb-3">
                        <label for="followup_file" class="form-label fw-bold">File Tindak Lanjut (opsional)</label>
                        <input type="file" class="form-control" id="followup_file" name="followup_file" accept=".png,.jpg,.jpeg,.pdf">
                        <div class="invalid-feedback" id="followup-file-error"></div>
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
    // Reset misconduct form and errors when modal is closed
    $('#misconductModal').on('hidden.bs.modal', function() {
        $('#misconductForm')[0].reset();
        $('#misconduct_id').val('');
        $('#misconductModalLabel').text('Tambah Pelanggaran');
        clearMisconductErrors();
        $('#misconduct-file-action-icons').html('');
        $('#remove_old_file').remove();
    });

    // Handle misconduct form submission
    $('#misconductForm').on('submit', function(e) {
        e.preventDefault();
        clearMisconductErrors();

        const formData = new FormData(this);
        const misconductId = $('#misconduct_id').val();
        
        let url = "{{ route('student-misconducts.store') }}";
        let method = 'POST';
        
        if (misconductId) {
            url = "{{ url('student-misconducts') }}/" + misconductId;
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
                    if (misconductId) {
                        updateMisconductRow(response.data);
                    } else {
                        addMisconductRow(response.data);
                    }

                    // Close modal and show success message
                    $('#misconductModal').modal('hide');
                    $('#misconductForm')[0].reset();
                    
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
                console.log(xhr);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(field => {
                        let fieldId, errorId;
                        
                        if (field.startsWith('followup_')) {
                            // Handle follow-up fields
                            fieldId = `#${field}`;
                            errorId = `#${field.replace('_', '-')}-error`;
                        } else {
                            // Handle misconduct fields
                            fieldId = `#misconduct_${field.replace('.', '_')}`;
                            errorId = `#misconduct-${field.replace('.', '-')}-error`;
                        }
                        
                        $(fieldId).addClass('is-invalid');
                        $(errorId).text(errors[field][0]);
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

    // Handle edit misconduct button click
    $(document).on('click', '.edit-misconduct', function() {
        clearMisconductErrors();
        const button = $(this);
        const id = button.data('id');
        const name = button.data('name');
        const category = button.data('category');
        const fullDate = button.data('date');
        const detail = button.data('detail');
        const file = button.data('file');
        
        const date = fullDate.split(' ')[0];

        $('#misconduct_id').val(id);
        $('#misconduct_name').val(name);
        $('#misconduct_category').val(category);
        $('#misconduct_date').val(date);
        $('#misconduct_detail').val(detail);

        // Tampilkan icon preview & trash jika user pilih file baru
        if (file) {
            let url = `/storage/misconducts/${file}`;
            let ext = file.split('.').pop().toLowerCase();
            let icon = `<a href="${url}" target="_blank" title="Preview"><i class="bi bi-eye ms-2"></i></a>`;
            icon += `<a href="#" id="remove-misconduct-file-btn" class="text-danger ms-2" title="Hapus File"><i class="bi bi-trash"></i></a>`;
            $('#misconduct-file-action-icons').html(icon);
            $('#misconduct_file').val(""); // reset file input
        } else {
            $('#misconduct-file-action-icons').html('');
        }

        $('#misconductModalLabel').text('Edit Pelanggaran');
        $('#misconductModal').modal('show');
    });

    // Handle delete misconduct button click
    $(document).on('click', '.delete-misconduct', function() {
        const id = $(this).data('id');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data pelanggaran akan dihapus permanen!",
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
                    url: "{{ url('student-misconducts') }}/" + id,
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

                            $(`#misconduct-${id}`).remove();
                            
                            // Check if there are any remaining rows except the "no data" row
                            const remainingRows = $('#misconductsTable tbody tr:not(#no-misconducts)').length;
                            
                            if (remainingRows === 0) {
                                $('#misconductsTable tbody').html(`
                                    <tr id="no-misconducts">
                                        <td colspan="7" class="text-center">Tidak ada data pelanggaran</td>
                                    </tr>
                                `);
                            } else {
                                // Reorder remaining rows
                                $('#misconductsTable tbody tr:not(#no-misconducts)').each(function(index) {
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

    // Tampilkan icon preview & trash jika user pilih file baru
    $('#misconduct_file').on('change', function() {
        const fileInput = this;
        if (fileInput.files && fileInput.files[0]) {
            let file = fileInput.files[0];
            let url = URL.createObjectURL(file);
            let ext = file.name.split('.').pop().toLowerCase();
            let icon = `<a href="${url}" target="_blank" title="Preview"><i class="bi bi-eye ms-2"></i></a>`;
            icon += `<a href="#" id="remove-misconduct-file-btn" class="text-danger ms-2" title="Hapus File"><i class="bi bi-trash"></i></a>`;
            $('#misconduct-file-action-icons').html(icon);
            $('#remove_old_file').remove();
        } else {
            $('#misconduct-file-action-icons').html('');
        }
    });

    // Hapus file dari tampilan jika klik icon trash
    $(document).on('click', '#remove-misconduct-file-btn', function(e) {
        e.preventDefault();
        $('#misconduct-file-action-icons').html('');
        $('#misconduct_file').val("");
        // Tambahkan hidden input untuk menandai penghapusan file lama
        if ($('#remove_old_file').length === 0) {
            $('#misconductForm').append('<input type="hidden" name="remove_old_file" id="remove_old_file" value="1">');
        }
    });

    // Helper function to add new misconduct row
    function addMisconductRow(misconduct) {
        const rowCount = $('#misconductsTable tbody tr:not(#no-misconducts)').length;
        const newRow = createMisconductRow(misconduct, rowCount);
        
        if ($('#no-misconducts').length) {
            $('#no-misconducts').remove();
        }
        
        $('#misconductsTable tbody').append(newRow);
    }

    // Helper function to update existing misconduct row
    function updateMisconductRow(misconduct) {
        const row = $(`#misconduct-${misconduct.id}`);
        const rowIndex = row.index();
        const newRow = createMisconductRow(misconduct, rowIndex);
        row.replaceWith(newRow);
    }

    // Helper function to create misconduct row HTML
    function createMisconductRow(misconduct, index) {
        const date = new Date(misconduct.date).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });

        const canEdit = {{ auth()->user()->can('edit-student') ? 'true' : 'false' }};
        
        let fileHtml = '';
        if (misconduct.file) {
            fileHtml = `<a href="/storage/${misconduct.file}" target="_blank" class="btn btn-outline-secondary btn-sm"><i class="bi bi-paperclip me-1"></i>Lihat Lampiran</a>`;
        }
        
        let actionsHtml = '';
        if (canEdit) {
            actionsHtml = `
                <div class="dropdown">
                    <button class="btn btn-sm btn-light border" type="button" id="dropdownMenuButton${misconduct.id}" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton${misconduct.id}">
                        <li>
                            <a class="dropdown-item" href="/student-misconducts/${misconduct.id}">
                                <i class="bi bi-eye me-2"></i> Detail
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item edit-misconduct" href="javascript:void(0);"
                                data-id="${misconduct.id}"
                                data-name="${misconduct.name}"
                                data-category="${misconduct.category}"
                                data-date="${misconduct.date}"
                                data-detail="${misconduct.detail}"
                                data-file="${misconduct.file}">
                                <i class="bi bi-pencil-square me-2"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger delete-misconduct" href="javascript:void(0);" data-id="${misconduct.id}">
                                <i class="bi bi-trash me-2"></i> Hapus
                            </a>
                        </li>
                    </ul>
                </div>
            `;
        }

        return `
            <tr id="misconduct-${misconduct.id}">
                <td>${index + 1}</td>
                <td>${misconduct.name}</td>
                <td>${misconduct.category}</td>
                <td>${date}</td>
                <td>${fileHtml}</td>
                <td>${misconduct.detail}</td>
                <td>${actionsHtml}</td>
            </tr>
        `;
    }

    // Helper function to clear misconduct form errors
    function clearMisconductErrors() {
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');
        
        // Also clear follow-up specific errors
        $('#followup_notes').removeClass('is-invalid');
        $('#followup-notes-error').text('');
        $('#followup_file').removeClass('is-invalid');
        $('#followup-file-error').text('');
    }
});
</script>
@endpush 