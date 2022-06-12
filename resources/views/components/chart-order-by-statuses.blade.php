<div>
    <div
        class="card"
        id="order-by-statuses-module"
    >
        <div class="card-header">
            <h3 class="card-title">{{ __('Order By Statuses') }}</h3>
        </div>
        <div
            class="card-body"
            style="position: relative: height: 350px;"
        >
            <canvas id="order-by-statuses-chart"></canvas>
        </div>
    </div>
    <script>
        const OrderByStatusesModule = (function() {
            const $el = $('#order-by-statuses-module');
            const $chart = document.getElementById('order-by-statuses-chart');
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
                    url: '{{ route('web-api.order-statuses.orders.index') }}',
                    success: function(response) {
                        chart.data = {
                            labels: response.data.map(value => value.name),
                            datasets: [{
                                data: response.data.map(value => value.total_orders),
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
