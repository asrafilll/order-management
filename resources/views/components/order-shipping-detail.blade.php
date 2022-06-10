@props(['order'])

<div>
    <form
        id="order-shipping-detail-module"
        action="{{ route('orders.shipping-detail.update', $order) }}"
        method="POST"
    >
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Shipping Detail') }}</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="shipping_date">
                        <span>{{ __('Date') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        name="shipping_date"
                        id="shipping_date"
                        class="form-control @error('shipping_date') is-invalid @enderror"
                        value="{{ old('shipping_date') ?? $order->shipping_date }}"
                    />
                    @error('shipping_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="shipping_airwaybill">
                        <span>{{ __('Airwaybill') }}</span>
                        <span class="text-danger">*</span>
                    </label>
                    <input
                        type="text"
                        name="shipping_airwaybill"
                        id="shipping_airwaybill"
                        class="form-control @error('shipping_airwaybill') is-invalid @enderror"
                        value="{{ old('shipping_airwaybill') ?? $order->shipping_airwaybill }}"
                    />
                    @error('shipping_airwaybill')
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
    <script>
        const OrderShippingDetail = (function() {
            const $el = $('#order-shipping-detail-module');
            const $shippingDate = $el.find('#shipping_date');

            init();

            function init() {
                $shippingDate.datetimepicker({
                    format: 'Y-m-d H:i:s',
                    minDate: 0,
                    minTime: 0,
                });
            }
        })();
    </script>
</div>
