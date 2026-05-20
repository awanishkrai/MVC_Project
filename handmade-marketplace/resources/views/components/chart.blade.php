@props(['id', 'type' => 'line', 'labels' => [], 'datasets' => [], 'height' => 240])

<canvas id="{{ $id }}" height="{{ $height }}" {{ $attributes }}></canvas>

@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    @endpush
@endonce

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const el = document.getElementById(@json($id));
    if (!el || el.dataset.chartReady) return;
    el.dataset.chartReady = '1';
    new Chart(el, {
        type: @json($type),
        data: {
            labels: @json($labels),
            datasets: @json($datasets),
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: {{ count($datasets) > 1 ? 'true' : 'false' }} } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } },
            },
        },
    });
});
</script>
@endpush
