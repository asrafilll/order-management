@props(['order'])

<div>
    <form
        id="order-payment-module"
        action="{{ route('orders.payment.update', $order) }}"
        method="POST"
    >
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ __('Payment') }}</h3>
            </div>
            <div class="card-body p-0">
                <div class="p-3 border-bottom">
                    <div class="row align-items-center mb-3">
                        <div class="col-lg">
                            <span>{{ __('Subtotal') }}</span>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-right">
                                {{ Config::get('app.currency') .
                                    ' ' .
                                    number_format(intval($order->items_price) - intval($order->items_discount)) }}
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-lg">
                            <span>{{ __('Shipping') }}</span>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-right">
                                {{ Config::get('app.currency') .
                                    ' ' .
                                    number_format(intval($order->shipping_price) - intval($order->shipping_discount)) }}
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-lg">
                            <span class="font-weight-bold">{{ __('Total') }}</span>
                        </div>
                        <div class="col-lg-4">
                            <div class="font-weight-bold text-right">
                                {{ Config::get('app.currency') . ' ' . number_format($order->total_price) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="row align-items-center mb-3">
                        <div class="col-lg">
                            <span>{{ __('Payment Method') }}</span>
                            <span class="text-danger">*</span>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-right">
                                <input
                                    type="hidden"
                                    name="payment_method_id"
                                    id="payment_method_id"
                                    value="{{ old('payment_method_id') ?? $order->payment_method_id }}"
                                />
                                <input
                                    type="text"
                                    name="payment_method_name"
                                    id="payment_method_name"
                                    class="form-control @error('payment_method_name') is-invalid @enderror @error('payment_method_id') is-invalid @enderror"
                                    value="{{ old('payment_method_name') ?? $order->payment_method_name }}"
                                />
                                @error('payment_method_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @error('payment_method_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row align-items-center mb-3">
                        <div class="col-lg">
                            <span>{{ __('Status') }}</span>
                            <span class="text-danger">*</span>
                        </div>
                        <div class="col-lg-4">
                            <div class="text-right">
                                <select
                                    name="payment_status"
                                    id="payment_status"
                                    class="form-control @error('payment_status') is-invalid @enderror"
                                >
                                    @foreach (\App\Enums\PaymentStatusEnum::toValues() as $paymentStatus)
                                        <option
                                            value="{{ $paymentStatus }}"
                                            @if (old('payment_status') == $paymentStatus || $order->payment_status == $paymentStatus) selected @endif
                                        >{{ __(Str::upper($paymentStatus)) }}</option>
                                    @endforeach
                                </select>
                                @error('payment_method_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
        const OrderPayment = (function() {
            const $el = $('#order-payment-module');
            const $paymentMethodId = $el.find('#payment_method_id');
            const $paymentMethodName = $el.find('#payment_method_name');

            init();

            function init() {
                $paymentMethodName.autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            method: 'GET',
                            url: '{{ route('web-api.payment-methods.index') }}',
                            data: {
                                q: request.term,
                            },
                            success: function(res) {
                                response(res.data.map(function(paymentMethod) {
                                    return {
                                        id: paymentMethod.id,
                                        label: paymentMethod.name,
                                        value: paymentMethod.name,
                                    };
                                }))
                            },
                        });
                    },
                    select: function(event, ui) {
                        $paymentMethodId.val(ui.item.id);
                    },
                });
            }
        })();
    </script>
</div>
