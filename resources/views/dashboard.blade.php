<x-app>
    <script src="{{ url('/') }}/plugins/chart.js/Chart.min.js"></script>
    <script>
        const ColorGenerator = (function() {
            return {
                generate: () => '#' + Math.floor(Math.random() * 16777215).toString(16),
            };
        })();
    </script>
    <x-content-header>
        <h1 class="m-0">{{ __('Dashboard') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div
                id="order-by-sources-module"
                class="col-lg-6"
            >
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Order By Sources') }}</h3>
                    </div>
                    <div
                        class="card-body"
                        style="position: relative: height: 350px;"
                    >
                        <canvas id="order-by-sources-chart"></canvas>
                        <script>
                            const OrderBySourcesModule = (function() {
                                const $el = $('#order-by-sources-module');
                                const $chart = document.getElementById('order-by-sources-chart');
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
                                        url: '{{ route('web-api.order-sources.orders.index') }}',
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
                </div>
            </div>
            <div
                id="customer-by-types-module"
                class="col-lg-6"
            >
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Customer By Types') }}</h3>
                    </div>
                    <div
                        class="card-body"
                        style="position: relative: height: 350px;"
                    >
                        <canvas id="customer-by-types-chart"></canvas>
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
                </div>
            </div>
            <div
                id="order-by-statuses-module"
                class="col-lg-6"
            >
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Order By Statuses') }}</h3>
                    </div>
                    <div
                        class="card-body"
                        style="position: relative: height: 350px;"
                    >
                        <canvas id="order-by-statuses-chart"></canvas>
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
                </div>
            </div>
        </div>
    </section>
</x-app>
