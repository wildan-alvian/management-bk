@extends('layout.index') 

@section('content')
<div class="container mt-5" style="font-family: 'Kumbh Sans';">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center">
            
            <img src="{{ asset('asset/images/profile.png') }}" alt="Foto Profil" class="rounded-circle me-3" width="45" height="45">
            <div>
                <h5 class="mb-0 fw-bold">M. Wildan Alvian Prastya</h5>
                <small class="text-muted">Administrator</small>
            </div>
        </div>
    </div>
    <hr class="my-3"> 
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Daftar Konseling</h4>
        <div class="d-flex">
            <form method="GET" action="{{ route('counseling.index') }}" class="d-flex">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control me-0" placeholder="Cari judul konseling" style="max-width: 150px;">
                <button type="submit" class="btn btn-outline-secondary me-3">
                    <i class="bi bi-search"></i> 
                </button>
            </form>  

            @if(request('search'))
                <a href="{{ route('counseling.index') }}" class="btn btn-outline-secondary me-3"> <i class="bi bi-x-circle-fill"></i>
                @endif

            <a href="{{ route('counseling.create') }}" 
   class="btn text-white fw-bold btn-orange">
   + Tambah konseling
</a>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle text-center">
        <thead class="table-light">
            <thead>
            <tr>
                <th>No.</th>
                <th>Jadwal</th>
                <th>Diajukan Oleh</th>
                <th>Tipe Konseling</th>
                <th>Judul Konseling</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($counselings as $index => $counseling)
                <tr>
                    <td>{{ $counselings->firstItem() + $index }}</td>
                    <td>
                        {{ $counseling->scheduled_at ? \Carbon\Carbon::parse($counseling->scheduled_at)->format('d M Y H:i') : '-' }}
                    </td>                    
                    <td>{{ $counseling->submitted_by ?? '-' }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $counseling->counseling_type)) }}</td>
                    <td>{{ $counseling->title }}</td>
                    <td>
                        @php
                            $statusColors = [
                                'new' => 'secondary',
                                'on_progress' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                'canceled' => 'dark',
                            ];
                        @endphp
                        <span class="badge bg-{{ $statusColors[$counseling->status] ?? 'secondary' }}">
                            {{ strtoupper(str_replace('_', ' ', $counseling->status)) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('counseling.edit', $counseling->id) }}" class="btn btn-sm btn-link" style="font-size: 18px;">
                            <i class="bi bi-three-dots-vertical"></i>
                        </a>
                        
                        <form action="{{ route('counseling.destroy', $counseling->id) }}" method="POST" class="d-inline">
                            @csrf
                        </form>                    
                </td>
            </tr>   
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data konseling.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $counselings->withQueryString()->links() }}
</div>
</div>
@endsection
