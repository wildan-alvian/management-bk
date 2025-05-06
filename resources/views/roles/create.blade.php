@extends('layout.index')

@section('content')
<div class="container mt-5" style="font-family: 'Kumbh Sans';">
    <div class="container">
        <div class="mb-3">
            <h2 class="fw-bold">Form Tambah Role</h2>
        </div>
        <div class="mb-4">
            <a href="{{ route('roles.index') }}" 
               class="fw-bold btn btn-sm rounded-pill btn-glow">
               <i class="bi bi-caret-left-fill me-1"></i> Kembali
            </a>         
        </div>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf

        <div class="card shadow-sm p-4 mb-5 bg-white rounded">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <label for="permission" class="form-label">Hak akses</label>
                        <select class="form-control" id="permission" name="permission" required>
                            @forelse ($permissions as $permission)
                                    <option value="{{ $permission->id }}" {{ in_array($permission->id, old('permissions') ?? []) ? 'selected' : '' }}>
                                        {{ $permission->name }}
                                    </option>
                                @empty
                            @endforelse
                        </select>
                        @if ($errors->has('permissions'))
                            <span class="text-danger">{{ $errors->first('permissions') }}</span>
                        @endif
                    </div>
                </div>


                <div class="d-flex justify-content-start">
                    <button type="submit" class="btn btn-primary me-2">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#cancelModal">
                        Batal
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
@endsection
