<div>
    <div id="return-order-by-days-module">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Return By Days') }}</h3>
                <div class="card-tools">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-toggle="modal"
                        data-target="#filter-ReturnOrderByDays"
                    >
                        <i class="fas fa-calendar-alt"></i>
                    </button>
                </div>
            </div>
            <div
                class="card-body"
                style="position: relative: height: 350px;"
            >
                <canvas id="return-order-by-days-chart"></canvas>
            </div>
        </div>
        <x-chart-date-filter-modal name="ReturnOrderByDays" />
    </div>
    <script>
        const ReturnOrderByDaysModule = (function() {
            const $el = $('#return-order-by-days-module');
            const $chart = document.getElementById('return-order-by-days-chart');
            const ctx = $chart.getContext('2d');

            const baseUrl = '{{ route('web-api.days.return-orders.index') }}';
            let chart;
            let url = baseUrl;

            init();

            function init() {
                chart = new Chart(ctx, {
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

                render();
            }

            function render() {
                $.ajax({
                    url: url,
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
