<div>
    <div
        class="card"
        id="customer-by-types-module"
    >
        <div class="card-header">
            <h3 class="card-title">{{ __('Customer By Types') }}</h3>
        </div>
        <div
            class="card-body"
            style="position: relative: height: 350px;"
        >
            <canvas id="customer-by-types-chart"></canvas>
        </div>
    </div>
    <script>
        const CustomerByTypesModule = (function() {
            const $el = $('#customer-by-types-module');
            const $chart = document.getElementById('customer-by-types-chart');
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
                    url: '{{ route('web-api.customer-types.customers.index') }}',
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
        })();
    </script>
</div>
