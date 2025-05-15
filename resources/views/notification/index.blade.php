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
                <tr style="cursor: pointer;" data-id="{{$notification->id}}">
                    @php
                        $contentStyle = [false => 'background-color: var(--bg-light);', true => ''];
                    @endphp
                    <td style="{{$contentStyle[$notification->status]}}">{{$notification->content}}</td>
                </tr>
            @empty
                <tr>
                    <td class="text-muted">Belum ada data notifikasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script>
        const rows = document.querySelectorAll('tbody tr[data-id]');

        rows.forEach(row => {
            row.addEventListener('click', function() {
                const rowId = this.getAttribute('data-id');

                window.location.href = '/notifications/read/' + rowId;
            });
        });
    </script>
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-end mt-4">
    {{ $notifications->withQueryString()->links('pagination::bootstrap-5') }}
</div>
@endsection
