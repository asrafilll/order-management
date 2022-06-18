<div>
    <div id="order-by-statuses-module">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Order By Statuses') }}</h3>
                <div class="card-tools">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-toggle="modal"
                        data-target="#filter-OrderByStatuses"
                    >
                        <i class="fas fa-calendar-alt"></i>
                    </button>
                </div>
            </div>
            <div
                class="card-body"
                style="position: relative: height: 350px;"
            >
                <canvas id="order-by-statuses-chart"></canvas>
            </div>
        </div>
        <x-chart-date-filter-modal name="OrderByStatuses" />
    </div>

    <script>
        const OrderByStatusesModule = (function() {
            const $el = $('#order-by-statuses-module');
            const $chart = document.getElementById('order-by-statuses-chart');
            const ctx = $chart.getContext('2d');

            const baseUrl = '{{ route('web-api.order-statuses.orders.index') }}';
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
