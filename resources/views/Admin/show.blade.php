@extends('layout.index')

@section('content')
<div class="container mt-5" style="font-family: 'Kumbh Sans';">
    <h2 class="fw-bold mb-4">Detail Data Admin</h2>

    <div class="mb-4">
        <a href="{{ route('admin.index') }}" class="fw-bold btn btn-sm rounded-pill btn-glow">
            <i class="bi bi-caret-left-fill me-1"></i> Kembali
        </a>         
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    
    <div class="card shadow-lg p-4 mb-5 bg-light rounded">
        <h5 class="fw-bold mb-3">Data Admin</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>NIP:</strong>
                    <p>{{ $admin->nip }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Nama:</strong>
                    <p>{{ $admin->name }}</p>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>Email:</strong>
                    <p>{{ $admin->email }}</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <strong>No Telepon:</strong>
                    <p>{{ $admin->phone }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card p-3 shadow-sm">
                    <strong>Alamat:</strong>
                    <p>{{ $admin->address }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection