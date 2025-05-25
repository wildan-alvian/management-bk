@extends('layout.index')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><i class="bi bi-person-plus-fill me-2"></i>Tambah Admin</h3>
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
            <i></i>Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    {{-- NIP --}}
                    <div class="col-md-6">
                        <label for="id_number" class="form-label fw-semibold">NIP</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                            <input type="text" id="id_number" name="id_number"
                                class="form-control @error('id_number') is-invalid @enderror"
                                value="{{ old('id_number') }}" required>
                            @error('id_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Nama --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Nama</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" id="name" name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" id="email" name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Telepon --}}
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold">No Telepon</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" id="phone" name="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="col-12">
                        <label for="address" class="form-label fw-semibold">Alamat</label>
                        <div class="input-group has-validation">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <textarea id="address" name="address" rows="3"
                                class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save2 me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
