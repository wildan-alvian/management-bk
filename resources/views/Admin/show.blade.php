@extends('layout.index')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">
            <i class="bi bi-person-lines-fill me-2"></i>Detail Data Admin
        </h3>
        <a href="{{ route('admin.index') }}" class="btn btn-outline-secondary">
            <i></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card p-4 shadow-sm mb-5">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm border-start border-primary border-4">
                    <strong><i class="bi bi-card-list me-2"></i>NIP:</strong>
                    <p class="mb-0">{{ $admin->id_number }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm border-start border-primary border-4">
                    <strong><i class="bi bi-person-fill me-2"></i>Nama:</strong>
                    <p class="mb-0">{{ $admin->name }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm border-start border-success border-4">
                    <strong><i class="bi bi-envelope-fill me-2"></i>Email:</strong>
                    <p class="mb-0">{{ $admin->email }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm border-start border-success border-4">
                    <strong><i class="bi bi-telephone-fill me-2"></i>No Telepon:</strong>
                    <p class="mb-0">{{ $admin->phone ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card p-3 shadow-sm border-start border-info border-4">
                    <strong><i class="bi bi-geo-alt-fill me-2"></i>Alamat:</strong>
                    <p class="mb-0">{{ $admin->address ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
