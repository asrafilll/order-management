@props(['order'])

<div class="card">
    <div class="card-header">
        <h3 class="card-title float-none">{{ __('Items') }}</h3>
    </div>
    <div class="card-body p-0">
        <div
            id="product-search-module"
            class="p-3 border-bottom"
        >
            <input
                type="search"
                name="search"
                id="search"
                class="form-control"
                placeholder="{{ __('Search product') }}"
            />
        </div>
        <script>
            const ProductSearch = (function() {
                const $el = $('#product-search-module');
                const $input = $el.find('#search');

                init();

                function init() {
                    $input.autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                method: 'GET',
                                url: '{{ route('web-api.product-variants.index') }}',
                                data: {
                                    q: request.term,
                                    status: '{{ \App\Enums\ProductStatusEnum::published()->value }}',
                                },
                                success: function(res) {
                                    response(res.data.map(function(productVariant) {
                                        const value =
                                            `${productVariant.product_name} - ${productVariant.name}`;
                                        return {
                                            label: value,
                                            value: value,
                                            id: productVariant.id,
                                        };
                                    }))
                                },
                            });
                        },
                        select: function(event, ui) {
                            AddOrderItem.submit(ui.item.id);
                        },
                    });
                }
            })();
        </script>
        <div
            id="add-order-item-module"
            class="d-none"
        >
            <form
                action="{{ route('orders.items.store', $order) }}"
                method="POST"
            >
                @csrf
                <input
                    type="hidden"
                    name="variant_id"
                    id="variant_id"
                />
                <input
                    type="submit"
                    id="add-order-item-submit"
                />
            </form>
        </div>
        <script>
            const AddOrderItem = (function() {
                const $el = $('#add-order-item-module');
                const $variantId = $el.find('#variant_id');
                const $submit = $el.find('#add-order-item-submit');

                function submit(value) {
                    $variantId.val(value);
                    $submit.click();
                }

                return {
                    submit: submit,
                };
            })();
        </script>
        <div
            id="update-order-item-module"
            class="table-responsive border-bottom"
        >
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>{{ __('Product') }}</th>
                        <th width="150">{{ __('Quantity') }}</th>
                        <th
                            width="150"
                            class="text-right"
                        >{{ __('Total') }}</th>
                        <th width="10"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                        <tr>
                            <td>
                                <dl>
                                    <dt>{{ $item->product_name }}</dt>
                                    <dd>
                                        <ul class="list-unstyled">
                                            <li>{{ $item->variant_name }}</li>
                                            <li>
                                                {{ Config::get('app.currency') . ' ' . number_format($item->variant_price) }}
                                            </li>
                                        </ul>
                                    </dd>
                                </dl>
                            </td>
                            <td>
                                <form
                                    action="{{ route('orders.items.update', [$order, $item]) }}"
                                    method="POST"
                                    class="order-item-form"
                                >
                                    @csrf
                                    @method('PUT')
                                    <input
                                        type="number"
                                        name="quantity"
                                        class="form-control order-item-quantity"
                                        value="{{ $item->quantity }}"
                                    />
                                </form>
                            </td>
                            <td class="text-right">
                                {{ Config::get('app.currency') . ' ' . number_format($item->variant_price * $item->quantity) }}
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-danger"
                                    data-toggle="modal"
                                    data-target="#modal-delete"
                                    data-action="{{ route('orders.items.destroy', [$order, $item]) }}"
                                >{{ __('Delete') }}</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <script>
            const UpdateOrderItem = (function() {
                const $el = $('#update-order-item-module');
                const $quantities = $el.find('.order-item-quantity');

                $quantities.on('change', handleChangeQuantity);

                function handleChangeQuantity() {
                    const $this = $(this);
                    const $form = $this.closest('.order-item-form');
                    $form.submit();
                }
            })();
        </script>
        <div class="p-3">
            <div class="row align-items-center mb-3">
                <div class="col-lg">
                    <span>{{ __('Subtotal') }}</span>
                </div>
                <div class="col-lg-4">
                    <div class="text-right">
                        {{ Config::get('app.currency') . ' ' . number_format(intval($order->items_price)) }}
                    </div>
                </div>
            </div>
            <div class="row align-items-center mb-3">
                <div class="col-lg">
                    <span>{{ __('Discount') }}</span>
                </div>
                <div class="col-lg-4">
                    <form
                        id="update-order-items-discount-module"
                        action="{{ route('orders.items-discount.update', $order) }}"
                        method="POST"
                    >
                        @csrf
                        @method('PUT')
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span
                                    class="input-group-text">{{ Config::get('app.currency') }}</span>
                            </div>
                            <input
                                type="number"
                                name="items_discount"
                                id="items_discount"
                                class="form-control text-right @error('items_discount') is-invalid @enderror"
                                value="{{ $order->items_discount }}"
                            />
                            @error('items_discount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </form>
                    <script>
                        const UpdateOrderItemsDiscount = (function() {
                            const $el = $('#update-order-items-discount-module');
                            const $itemsDiscount = $el.find('#items_discount');

                            $itemsDiscount.on('change', handleChange)

                            function handleChange() {
                                $el.submit();
                            }
                        })();
                    </script>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg">
                    <span class="font-weight-bold">{{ __('Total') }}</span>
                </div>
                <div class="col-lg-4">
                    <div class="font-weight-bold text-right">
                        {{ Config::get('app.currency') .
                            ' ' .
                            number_format(intval($order->items_price) - intval($order->items_discount)) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
