@extends('layout.index')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Daftar Notifikasi</h4>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle text-center">
        <thead class="table-light">
            <tr>
                <th>Notifikasi ({{$unreadCount}})</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($notifications as $index => $notification)
                <tr style="cursor: pointer;">
                    @php
                        $contentStyle = [false => '', true => 'text-muted'];
                    @endphp
                    <td class="{{$contentStyle[$notification->status]}}">{{$notification->content}}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-muted">Belum ada data notifikasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        const rows = document.querySelectorAll('tbody tr');

        rows.forEach(row => {
            row.addEventListener('click', function() {
                window.location.href = '/counseling'
            });
        });
    </script>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-end mt-4">
    {{ $notifications->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endsection
