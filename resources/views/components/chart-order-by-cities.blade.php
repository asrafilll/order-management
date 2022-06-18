<div>
    <div id="order-by-cities-module">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Order By Cities') }}</h3>
                <div class="card-tools">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-toggle="modal"
                        data-target="#filter-OrderByCities"
                    >
                        <i class="fas fa-calendar-alt"></i>
                    </button>
                </div>
            </div>
            <div
                class="card-body"
                style="position: relative: height: 350px;"
            >
                <canvas id="order-by-cities-chart"></canvas>
            </div>
        </div>
        <x-chart-date-filter-modal name="OrderByCities" />
    </div>
    <script>
        const OrderByCitiesModule = (function() {
            const $el = $('#order-by-cities-module');
            const $chart = document.getElementById('order-by-cities-chart');
            const ctx = $chart.getContext('2d');

            const baseUrl = '{{ route('web-api.cities.orders.index') }}';
            let chart;
            let url = baseUrl;

            init();

            function init() {
                chart = new Chart(ctx, {
                    type: 'pie',
                    options: {
                        legend: {
                            position: 'bottom',
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
