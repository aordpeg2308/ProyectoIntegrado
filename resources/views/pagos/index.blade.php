<div class="bg-white/80 p-6 rounded-xl shadow-lg mb-10">
    <h2 class="text-2xl font-bold mb-6 text-center text-[#2e2d55]">Pagos mensuales por usuario</h2>
    <canvas id="graficoPagos" height="120"></canvas>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = {!! json_encode($grafica->keys()) !!};
    const usuarios = {!! json_encode($grafica->flatMap(fn($mes) => $mes->keys())->unique()->values()) !!};

    const nombres = @json($grafica->flatMap(fn($mes) => $mes)->mapWithKeys(fn($val, $key) => [$key => App\Models\User::find($key)?->nombre ?? "ID $key"])->unique());

    const datasets = usuarios.map(userId => {
        return {
            label: nombres[userId] ?? `ID ${userId}`,
            data: labels.map(label => {
                return {{ Js::from($grafica) }}[label]?.[userId] ?? 0;
            }),
            borderColor: '#' + Math.floor(Math.random()*16777215).toString(16),
            fill: false,
            tension: 0.3
        };
    });

    new Chart(document.getElementById('graficoPagos'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'Meses abonados por usuario'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    title: { display: true, text: 'Meses pagados' }
                }
            }
        }
    });
</script>
@endpush
