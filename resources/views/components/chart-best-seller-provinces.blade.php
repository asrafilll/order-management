<div>
    <div id="best-seller-provinces-module">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Best Seller Provinces') }}</h3>
                <div class="card-tools">
                    <button
                        type="button"
                        class="btn btn-default btn-sm"
                        data-toggle="modal"
                        data-target="#filter-BestSellerProvinces"
                    >
                        <i class="fas fa-calendar-alt"></i>
                    </button>
                </div>
            </div>
            <div
                class="card-body"
                style="position: relative: height: 350px;"
            >
                <canvas id="best-seller-provinces-chart"></canvas>
            </div>
        </div>
        <x-chart-date-filter-modal name="BestSellerProvinces" />
    </div>
    <script>
        const BestSellerProvincesModule = (function() {
            const $el = $('#best-seller-provinces-module');
            const $chart = document.getElementById('best-seller-provinces-chart');
            const ctx = $chart.getContext('2d');

            const baseUrl = '{{ route('web-api.provinces.best-seller.index') }}';
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
