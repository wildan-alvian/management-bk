@extends('layout.index')

@section('content')
<div class="container mt-5">
    <h3 class="fw-bold mb-4">Tambah Guru BK</h3>

    <div class="mb-4">
        <a href="{{ route('counselors.index') }}" class="btn rounded-pill btn-secondary">
            <i class="bi bi-caret-left-fill me-1"></i> Kembali
        </a>         
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('counselors.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-start">
                            <label for="nip" class="form-label fw-bold">NIP</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                   name="nip" id="nip" value="{{ old('nip') }}" required>
                        </div>
                        @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="text-start">
                            <label for="name" class="form-label fw-bold">Nama</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" id="name" value="{{ old('name') }}" required>
                        </div>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="text-start">
                            <label for="email" class="form-label fw-bold">Email</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" id="email" value="{{ old('email') }}" required>
                        </div>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="text-start">
                            <label for="phone" class="form-label fw-bold">No Telepon</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" id="phone" value="{{ old('phone') }}">
                        </div>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <div class="text-start">
                            <label for="address" class="form-label fw-bold">Alamat</label>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      name="address" id="address" rows="3">{{ old('address') }}</textarea>
                        </div>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3">
                    <a href="{{ route('counselors.index') }}" class="btn btn-secondary me-2">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
