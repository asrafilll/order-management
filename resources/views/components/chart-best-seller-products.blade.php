<div>
    <div
        class="card"
        id="best-seller-products-module"
    >
        <div class="card-header">
            <h3 class="card-title">{{ __('Best Seller Products On Current Month') }}</h3>
        </div>
        <div
            class="card-body"
            style="position: relative: height: 350px;"
        >
            <canvas id="best-seller-products-chart"></canvas>
        </div>
    </div>
    <script>
        const BestSellerProductsModule = (function() {
            const $el = $('#best-seller-products-module');
            const $chart = document.getElementById('best-seller-products-chart');
            const ctx = $chart.getContext('2d');

            init();

            function init() {
                const chart = new Chart(ctx, {
                    type: 'bar',
                    options: {
                        legend: {
                            display: false,
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                },
                            }],
                        },
                    },
                });

                $.ajax({
                    url: '{{ route('web-api.products.best-seller.index') }}',
                    success: function(response) {
                        chart.data = {
                            labels: response.data.map(value => value.name),
                            datasets: [{
                                label: response.data.map(value => value.name),
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
