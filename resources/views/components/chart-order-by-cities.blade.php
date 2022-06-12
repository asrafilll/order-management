<div>
    <div
        class="card"
        id="order-by-cities-module"
    >
        <div class="card-header">
            <h3 class="card-title">{{ __('Order By Cities') }}</h3>
        </div>
        <div
            class="card-body"
            style="position: relative: height: 350px;"
        >
            <canvas id="order-by-cities-chart"></canvas>
        </div>
    </div>
    <script>
        const OrderByCitiesModule = (function() {
            const $el = $('#order-by-cities-module');
            const $chart = document.getElementById('order-by-cities-chart');
            const ctx = $chart.getContext('2d');

            init();

            function init() {
                const chart = new Chart(ctx, {
                    type: 'pie',
                    options: {
                        legend: {
                            position: 'bottom',
                        },
                    },
                });

                $.ajax({
                    url: '{{ route('web-api.cities.orders.index') }}',
                    success: function(response) {
                        chart.data = {
                            labels: response.data.map(value => value.city),
                            datasets: [{
                                data: response.data.map(value => value.total),
                                backgroundColor: response.data.map(label => ColorGenerator
                                    .generate()),
                            }]
                        };
                        chart.update();
                    },
                });
            }
        })();
    </script>
</div>
