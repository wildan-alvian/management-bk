@extends('layout.index')

@section('content')
<div class="container mt-5">
    <div class="container">
        <div class="mb-3">
            <h3 class="fw-bold">Form Tambah Role</h3>
        </div>
        <div class="mb-4">
            <a href="{{ route('roles.index') }}" class="btn rounded-pill btn-secondary">
                <i class="bi bi-caret-left-fill me-1"></i> Kembali
            </a>         
        </div>

        <div class="card shadow-sm p-4 mb-5 bg-white rounded">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="text-start">
                            <label for="name" class="form-label fw-bold">Nama</label>
                        </div>
                        <input type="text" class="form-control" id="name" name="name" required>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <div class="text-start">
                            <label for="permissions" class="form-label fw-bold">Hak akses</label>
                        </div>
                        <select class="form-select" id="permissions" name="permissions[]" multiple required>
                            @foreach ($permissions as $permission)
                                <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                                    {{ $permission->name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('permissions'))
                            <span class="text-danger">{{ $errors->first('permissions') }}</span>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3">
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>

        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="cancelModalLabel">Konfirmasi Batal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin untuk membatalkan editan?
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('roles.index') }}" class="btn btn-danger">Yes</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#permissions').select2({
            placeholder: 'Pilih hak akses',
            allowClear: true
        });
    });
</script>
@endpush

@endsection
