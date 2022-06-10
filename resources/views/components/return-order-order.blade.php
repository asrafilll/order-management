@props(['returnOrder'])

<div
    class="card"
    style="height: calc(100% - 1rem)"
>
    <div class="card-header">
        <h3 class="card-title">{{ __('Order') }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <dl>
                    <dt>{{ __('ID') }}</dt>
                    <dd>{{ $returnOrder->order->id }}</dd>
                </dl>
            </div>
            <div class="col">
                <dl>
                    <dt>{{ __('Customer') }}</dt>
                    <dd>{{ $returnOrder->order->customer_name }}</dd>
                </dl>
            </div>
            <div class="col">
                <dl>
                    <dt>{{ __('Created At') }}</dt>
                    <dd>{{ $returnOrder->order->created_at }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
