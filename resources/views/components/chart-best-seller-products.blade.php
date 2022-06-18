<div>
    <div id="best-seller-products-module">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Best Seller Products') }}</h3>
                <div class="card-tools">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-toggle="modal"
                        data-target="#filter-BestSellerProducts"
                    >
                        <i class="fas fa-calendar-alt"></i>
                    </button>
                </div>
            </div>
            <div
                class="card-body"
                style="position: relative: height: 350px;"
            >
                <canvas id="best-seller-products-chart"></canvas>
            </div>
        </div>
        <x-chart-date-filter-modal name="BestSellerProducts" />
    </div>
    <script>
        const BestSellerProductsModule = (function() {
            const $el = $('#best-seller-products-module');
            const $chart = document.getElementById('best-seller-products-chart');
            const ctx = $chart.getContext('2d');

            const baseUrl = '{{ route('web-api.products.best-seller.index') }}';
            let chart;
            let url = baseUrl;

            init();

            function init() {
                chart = new Chart(ctx, {
                    type: 'bar',
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

                render();
            }

            function render() {
                $.ajax({
                    url: url,
                    success: function(response) {
                        chart.data = {
                            labels: response.data.map(value => value.name),
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

            function setParams(params) {
                url = baseUrl + '?' + params;

                render();
            }

            return {
                setParams: setParams,
            };
        })();
    </script>
</div>
