@extends('layout.index')

@section('content')
<div class="container-fluid mt-4">
    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Konseling</h6>
                            <h2 class="mt-2 mb-0">{{ $totalCounseling }}</h2>
                        </div>
                        <i class="bi bi-file-earmark-text fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Konseling Baru</h6>
                            <h2 class="mt-2 mb-0">{{ $newCounseling }}</h2>
                        </div>
                        <i class="bi bi-file-earmark-plus fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Konseling Disetujui</h6>
                            <h2 class="mt-2 mb-0">{{ $approvedCounseling }}</h2>
                        </div>
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Konseling Ditolak</h6>
                            <h2 class="mt-2 mb-0">{{ $rejectedCounseling }}</h2>
                        </div>
                        <i class="bi bi-x-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-3 mb-4">
        <!-- Monthly Counseling Chart -->
        <div class="{{ ($isAdmin || $isGuidanceCounselor) ? 'col-md-8' : 'col-md-12' }}">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Statistik Konseling Tahun {{ date('Y') }}
                        @if($isStudent || $isParent)
                            (Data Anda)
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Counseling Type Distribution (Only for Admin and Guidance Counselor) -->
        @if($isAdmin || $isGuidanceCounselor)
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Distribusi Tipe Konseling</h5>
                </div>
                <div class="card-body">
                    <canvas id="typeChart" height="300"></canvas>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Recent Counseling and User Stats -->
    <div class="row g-3">
        <!-- Recent Counseling Requests -->
        <div class="{{ $isAdmin ? 'col-md-8' : 'col-md-12' }}">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        Pengajuan Konseling Terbaru
                        @if($isStudent || $isParent)
                            (Data Anda)
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="min-height: fit-content">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Diajukan Oleh</th>
                                    <th>Tipe</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentCounseling as $counseling)
                                <tr>
                                    <td>{{ $counseling->created_at->format('d M Y') }}</td>
                                    <td>{{ $counseling->submitted_by }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $counseling->counseling_type)) }}</td>
                                    <td>{{ $counseling->title }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'new' => 'secondary',
                                                'approved' => 'success',
                                                'rejected' => 'danger'
                                            ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$counseling->status] ?? 'secondary' }}">
                                            {{ strtoupper($counseling->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Statistics (Only for Admin) -->
        @if($isAdmin)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Statistik Pengguna</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Guru BK
                            <span class="badge bg-primary rounded-pill">{{ $usersByRole['counselors'] }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Siswa
                            <span class="badge bg-primary rounded-pill">{{ $usersByRole['students'] }}</span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            Wali Murid
                            <span class="badge bg-primary rounded-pill">{{ $usersByRole['parents'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Jumlah Konseling',
                data: @json($counselingCounts),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    @if($isAdmin || $isGuidanceCounselor)
    // Counseling Type Chart
    const typeCtx = document.getElementById('typeChart').getContext('2d');
    new Chart(typeCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($counselingTypes->pluck('counseling_type')->map(function($type) {
                return ucfirst(str_replace('_', ' ', $type));
            })) !!},
            datasets: [{
                data: {!! json_encode($counselingTypes->pluck('total')) !!},
                backgroundColor: [
                    'rgb(255, 99, 132)',
                    'rgb(54, 162, 235)',
                    'rgb(255, 205, 86)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
    @endif
</script>
@endpush
@endsection 