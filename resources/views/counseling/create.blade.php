@extends('layout.index')

@section('content')
<div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row">
        <div class="container mt-5">
            <h3 class="fw-bold mb-4">Tambah Konseling</h3>

            <div class="mb-4">
                <a href="{{ route('counseling.index') }}" class="btn rounded-pill btn-secondary">
                    <i class="bi bi-caret-left-fill me-1"></i> Kembali
                </a>         
            </div>

            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('counseling.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="text-start">
                                    <label for="scheduled_at" class="form-label fw-bold">Jadwal Konseling</label>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                    <input type="datetime-local" name="scheduled_at" id="scheduled_at" 
                                           class="form-control @error('scheduled_at') is-invalid @enderror" 
                                           value="{{ old('scheduled_at') }}" required>
                                </div>
                                @error('scheduled_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="text-start">
                                    <label for="counseling_type" class="form-label fw-bold">Tipe Konseling</label>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                    <select name="counseling_type" id="counseling_type" 
                                            class="form-select @error('counseling_type') is-invalid @enderror" required>
                                        <option value="">-- Pilih Tipe --</option>
                                        <option value="siswa" {{ old('counseling_type') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                        <option value="wali_murid" {{ old('counseling_type') == 'wali_murid' ? 'selected' : '' }}>Wali Murid</option>
                                    </select>
                                </div>
                                @error('counseling_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="text-start">
                                    <label for="title" class="form-label fw-bold">Judul Konseling</label>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-chat-left-text"></i></span>
                                    <input type="text" name="title" id="title" 
                                           class="form-control @error('title') is-invalid @enderror" 
                                           value="{{ old('title') }}" required>
                                </div>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <div class="text-start">
                                    <label for="description" class="form-label fw-bold">Deskripsi</label>
                                </div>
                                <div class="input-group has-validation">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                                            rows="3">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4 pt-3">
                            <a href="{{ route('counseling.index') }}" class="btn btn-secondary me-2">
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
    </div>
</div>
@endsection