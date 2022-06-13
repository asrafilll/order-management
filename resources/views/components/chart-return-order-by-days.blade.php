<div>
    <div
        class="card"
        id="return-order-by-days-module"
    >
        <div class="card-header">
            <h3 class="card-title">{{ __('Order By Cities') }}</h3>
        </div>
        <div
            class="card-body"
            style="position: relative: height: 350px;"
        >
            <canvas id="return-order-by-days-chart"></canvas>
        </div>
    </div>
    <script>
        const ReturnOrderByDaysModule = (function() {
            const $el = $('#return-order-by-days-module');
            const $chart = document.getElementById('return-order-by-days-chart');
            const ctx = $chart.getContext('2d');

            init();

            function init() {
                const chart = new Chart(ctx, {
                    type: 'line',
                    options: {
                        legend: {
                            display: false,
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 1,
                                },
                            }],
                        },
                    },
                });

                $.ajax({
                    url: '{{ route('web-api.days.return-orders.index') }}',
                    success: function(response) {
                        const labels = response.data.map(value => value.date);
                        const data = response.data.map(value => value.total);
                        chart.data = {
                            labels: labels,
                            datasets: [{
                                data: data,
                                backgroundColor: 'red',
                                borderColor: 'red',
                                fill: false,
                                tension: 0,
                            }],
                        };
                        chart.update();
                    },
                });
            }
        })();
    </script>
</div>
