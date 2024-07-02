<div>
    <h2>{{ $this->getHeading() }}</h2>
    <div style="height: 300px;">
        <canvas id="chart-{{ $this->id }}"></canvas>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('chart-{{ $this->id }}').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($this->getData()['labels']),
                        datasets: @json($this->getData()['datasets']),
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                display: true,
                            },
                            y: {
                                display: true,
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
</div>
