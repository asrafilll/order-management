<div>
    <div id="customer-by-types-module">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Customer By Types') }}</h3>
                <div class="card-tools">
                    <button
                        type="button"
                        class="btn btn-default"
                        data-toggle="modal"
                        data-target="#filter-CustomerByTypes"
                    >
                        <i class="fas fa-calendar-alt"></i>
                    </button>
                </div>
            </div>
            <div
                class="card-body"
                style="position: relative: height: 350px;"
            >
                <canvas id="customer-by-types-chart"></canvas>
            </div>
        </div>
        <x-chart-date-filter-modal name="CustomerByTypes" />
    </div>
    <script>
        const CustomerByTypesModule = (function() {
            const $el = $('#customer-by-types-module');
            const $chart = document.getElementById('customer-by-types-chart');
            const ctx = $chart.getContext('2d');

            const baseUrl = '{{ route('web-api.customer-types.customers.index') }}';
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
                                data: response.data.map(value => value.total_customers),
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
