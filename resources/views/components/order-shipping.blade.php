@props(['order'])

<div>
    <form
        id="order-shipping-module"
        action="{{ route('orders.shipping.update', $order) }}"
        method="POST"
    >
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Shipping') }}</h3>
            </div>
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-lg">
                        <span>{{ __('Courier Name') }}</span>
                            <span class="text-danger">*</span>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-right">
                            <input
                                type="hidden"
                                name="shipping_id"
                                id="shipping_id"
                                value="{{ old('shipping_id') ?? $order->shipping_id }}"
                            />
                            <input
                                type="text"
                                name="shipping_name"
                                id="shipping_name"
                                class="form-control @error('shipping_name') is-invalid @enderror @error('shipping_id') is-invalid @enderror"
                                value="{{ old('shipping_name') ?? $order->shipping_name }}"
                            />
                            @error('shipping_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @error('shipping_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-lg">
                        <span>{{ __('Price') }}</span>
                        <span class="text-danger">*</span>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-right">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text">{{ Config::get('app.currency') }}</span>
                                </div>
                                <input
                                    type="text"
                                    name="shipping_price"
                                    id="shipping_price"
                                    class="form-control text-right @error('shipping_price') is-invalid @enderror"
                                    value="{{ old('shipping_price') ?? $order->shipping_price }}"
                                />
                                @error('shipping_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-lg">
                        <span>{{ __('Discount') }}</span>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-right">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span
                                        class="input-group-text">{{ Config::get('app.currency') }}</span>
                                </div>
                                <input
                                    type="text"
                                    name="shipping_discount"
                                    id="shipping_discount"
                                    class="form-control text-right @error('shipping_discount') is-invalid @enderror"
                                    value="{{ old('shipping_discount') ?? $order->shipping_discount }}"
                                />
                                @error('shipping_discount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
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
                                number_format(intval($order->shipping_price) - intval($order->shipping_discount)) }}
                        </div>
                    </div>
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
    <script>
        const OrderShipping = (function() {
            const $el = $('#order-shipping-module');
            const $shippingId = $el.find('#shipping_id');
            const $shippingName = $el.find('#shipping_name');

            init();

            function init() {
                $shippingName.autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            method: 'GET',
                            url: '{{ route('web-api.shippings.index') }}',
                            data: {
                                q: request.term,
                            },
                            success: function(res) {
                                response(res.data.map(function(shipping) {
                                    return {
                                        id: shipping.id,
                                        label: shipping.name,
                                        value: shipping.name,
                                    };
                                }))
                            },
                        });
                    },
                    select: function(event, ui) {
                        $shippingId.val(ui.item.id);
                    },
                });
            }
        })();
    </script>
</div>
