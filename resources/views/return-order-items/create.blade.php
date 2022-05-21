<x-app>
    <x-content-header>
        <h1 class="m-0">{{ __('Create Return Order Item') }}</h1>
    </x-content-header>

    <section class="content">
        <div class="row">
            <div class="col-lg-6">
                <form
                    action="{{ route('return-order-items.store') }}"
                    method="POST"
                    novalidate
                >
                    @csrf
                    <div class="card">
                        <div class="card-body">
                            <div
                                class="form-group"
                                id="search-order-module"
                            >
                                <label for="order">
                                    <span>{{ __('Order') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="hidden"
                                    id="order_id"
                                    name="order_id"
                                />
                                <input
                                    type="text"
                                    id="order"
                                    name="order"
                                    class="form-control @error('order_id') is-invalid @enderror"
                                />
                                @error('order_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                const SearchOrder = (function() {
                                    const $el = $('#search-order-module');
                                    const $input = $el.find('#order');
                                    const $id = $el.find('#order_id');

                                    init();

                                    function init() {
                                        $input.autocomplete({
                                            source: function(request, response) {
                                                $.ajax({
                                                    method: 'GET',
                                                    url: '{{ route('web-api.orders.index') }}',
                                                    data: {
                                                        q: request.term,
                                                        status: '{{ \App\Enums\OrderStatusEnum::completed()->value }}',
                                                    },
                                                    success: function(res) {
                                                        response(res.data.map(function(order) {
                                                            const label =
                                                                `${order.id} (${order.customer_name})`;
                                                            return {
                                                                id: order.id,
                                                                label: label,
                                                                value: label,
                                                            };
                                                        }))
                                                    },
                                                });
                                            },
                                            select: function(event, ui) {
                                                $id.val(ui.item.id);
                                                SearchOrderItem.setOrderId(ui.item.id);
                                            },
                                        });
                                    }
                                })();
                            </script>
                            <div
                                class="form-group"
                                id="search-order-item-module"
                            >
                                <label for="item">
                                    <span>{{ __('Item') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="hidden"
                                    id="order_item_id"
                                    name="order_item_id"
                                />
                                <input
                                    type="text"
                                    id="order_item"
                                    name="order_item"
                                    class="form-control @error('order_item_id') is-invalid @enderror"
                                    disabled
                                />
                                @error('order_item_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <script>
                                const SearchOrderItem = (function() {
                                    let orderId = null;

                                    const $el = $('#search-order-item-module');
                                    const $input = $el.find('#order_item');
                                    const $id = $el.find('#order_item_id');

                                    init();

                                    function init() {
                                        if (!orderId || orderId.length < 1) {
                                            return;
                                        }

                                        $input.removeAttr('disabled');

                                        if ($input.autocomplete('instance')) {
                                            $input.autocomplete('destroy');
                                        }

                                        $input.autocomplete({
                                            source: function(request, response) {
                                                $.ajax({
                                                    method: 'GET',
                                                    url: '{{ route('web-api.order-items.index') }}',
                                                    data: {
                                                        q: request.term,
                                                        order_id: orderId,
                                                    },
                                                    success: function(res) {
                                                        response(res.data.map(function(orderItem) {
                                                            const label =
                                                                `${orderItem.product_name} - ${orderItem.variant_name}`;
                                                            return {
                                                                id: orderItem.id,
                                                                label: label,
                                                                value: label,
                                                            };
                                                        }))
                                                    },
                                                });
                                            },
                                            select: function(event, ui) {
                                                $id.val(ui.item.id);
                                            },
                                        });
                                    }

                                    function setOrderId(newOrderId) {
                                        orderId = newOrderId;
                                        $input.val(null);
                                        $input.attr('disabled', true);
                                        init();
                                    }

                                    return {
                                        setOrderId: setOrderId,
                                    };
                                })();
                            </script>
                            <div class="form-group">
                                <label for="quantity">
                                    <span>{{ __('Quantity') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="quantity"
                                    name="quantity"
                                    class="form-control @error('quantity') is-invalid @enderror"
                                    value="{{ old('quantity') }}"
                                />
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="reason">
                                    <span>{{ __('Reason') }}</span>
                                </label>
                                <input
                                    type="text"
                                    id="reason"
                                    name="reason"
                                    class="form-control @error('reason') is-invalid @enderror"
                                    value="{{ old('reason') }}"
                                />
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="publish">
                                    <span>{{ __('Publish') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <select
                                    id="publish"
                                    name="publish"
                                    class="form-control @error('publish') is-invalid @enderror"
                                >
                                    <option value="0">{{ __('No') }}</option>
                                    <option value="1">{{ __('Yes') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >{{ __('Save') }}</button>
                            <a
                                href="{{ route('return-order-items.index') }}"
                                class="btn btn-default"
                            >{{ __('Back') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app>
