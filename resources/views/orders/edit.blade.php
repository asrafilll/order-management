<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Edit Order') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-none">{{ __('Products') }}</h3>
                    </div>
                    <div class="card-body">
                        <div id="product-search-module">
                            <input
                                type="search"
                                name="search"
                                id="search"
                                class="form-control"
                                placeholder="{{ __('Search product') }}"
                            />
                        </div>
                        <script>
                            const ProductSearch = (function () {
                                const $el = $('#product-search-module');
                                const $input = $el.find('#search');

                                init();

                                function init() {
                                    $input.autocomplete({
                                        source: function (request, response) {
                                            $.ajax({
                                                method: 'GET',
                                                url: '{{ route('web-api.product-variants.index') }}',
                                                data: {
                                                    q: request.term,
                                                    status: '{{ \App\Enums\ProductStatusEnum::published()->value }}',
                                                },
                                                success: function (res) {
                                                    response(res.data.map(function (productVariant) {
                                                        return {
                                                            label: `${productVariant.product_name} - ${productVariant.name}`,
                                                            value: productVariant.id,
                                                        };
                                                    }))
                                                },
                                            });
                                        },
                                        select: function (event, ui) {
                                            console.log(ui.item);
                                        }
                                    });
                                }
                            })();
                        </script>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title float-none">{{ __('General Information') }}</h3>
                        @if ($order->isEditable())
                            <div class="ml-auto">
                                <a
                                    href="{{ route('orders.general-information.edit', $order) }}">{{ __('Edit') }}</a>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <dl>
                            <dt>{{ __('Source') }}</dt>
                            <dd>{{ $order->source_name }}</dd>
                            <dt>{{ __('Customer') }}</dt>
                            <dd>
                                <ul class="list-unstyled">
                                    <li>{{ $order->customer_name }}</li>
                                    <li>{{ $order->customer_phone }}</li>
                                    <li>{{ $order->customer_address }}</li>
                                    <li>{{ $order->customer_village }}</li>
                                    <li>{{ $order->customer_subdistrict }}</li>
                                    <li>{{ $order->customer_city }}</li>
                                    <li>{{ $order->customer_province }}</li>
                                    <li>{{ $order->customer_postal_code }}</li>
                                </ul>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app>
