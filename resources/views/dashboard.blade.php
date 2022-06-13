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
            <div class="col-lg-6">
                <x-chart-order-by-sources />
            </div>
            <div class="col-lg-6">
                <x-chart-customer-by-types />
            </div>
            <div class="col-lg-6">
                <x-chart-order-by-statuses />
            </div>
            <div class="col-lg-6">
                <x-chart-order-by-cities />
            </div>
            <div class="col-lg-6">
                <x-chart-return-order-by-days />
            </div>
            <div class="col-lg-6">
                <x-chart-best-seller-products />
            </div>
        </div>
    </section>
</x-app>
