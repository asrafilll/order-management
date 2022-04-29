<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Edit Order') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title float-none">{{ __('Items') }}</h3>
                    </div>
                    <div class="card-body p-0">
                        @if ($order->isEditable())
                            <div
                                id="product-search-module"
                                class="p-3 border"
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
                        @endif
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
                            class="table-responsive"
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
                                                @if ($order->isEditable())
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
                                                @else
                                                    {{ $item->quantity }}
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                {{ Config::get('app.currency') . ' ' . number_format($item->variant_price * $item->quantity) }}
                                            </td>
                                            <td>
                                                @if ($order->isEditable())
                                                    <button
                                                        type="button"
                                                        class="btn btn-danger"
                                                        data-toggle="modal"
                                                        data-target="#modal-delete"
                                                        data-action="{{ route('orders.items.destroy', [$order, $item]) }}"
                                                    >{{ __('Delete') }}</button>
                                                @endif
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
                        <div class="border p-3">
                            <div class="row align-items-center mb-3">
                                <div class="col-lg">
                                    <span>{{ __('Subtotal') }}</span>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-right">
                                        {{ Config::get('app.currency') . ' ' . number_format($order->items_price) }}
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
                            <div class="row align-items-center mb-3">
                                <div class="col-lg">
                                    <span class="font-weight-bold">{{ __('Total') }}</span>
                                </div>
                                <div class="col-lg-4">
                                    <div class="font-weight-bold text-right">
                                        {{ Config::get('app.currency') . ' ' . number_format($order->items_price - $order->items_discount) }}
                                    </div>
                                </div>
                            </div>
                        </div>
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
                <form
                    action="{{ route('orders.note.update', $order) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">{{ __('Note') }}</div>
                        <div class="card-body">
                            <input
                                type="text"
                                name="note"
                                id="note"
                                class="form-control"
                                value="{{ $order->note }}"
                            />
                        </div>
                        <div class="card-footer">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
                <form
                    id="contributors-module"
                    method="POST"
                >
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">{{ __('Contributors') }}</div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="sales_name">
                                    <span>{{ __('Sales') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="sales_name"
                                    id="sales_name"
                                    class="form-control @error('sales_name') is-invalid @enderror"
                                    value="{{ $order->sales_name }}"
                                />
                                @error('sales_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="creator_name">
                                    <span>{{ __('Creator') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="creator_name"
                                    id="creator_name"
                                    class="form-control @error('creator_name') is-invalid @enderror"
                                    value="{{ $order->creator_name }}"
                                />
                                @error('creator_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="packer_name">
                                    <span>{{ __('Packer') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="packer_name"
                                    id="packer_name"
                                    class="form-control @error('packer_name') is-invalid @enderror"
                                    value="{{ $order->packer_name }}"
                                />
                                @error('packer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app>
