@props(['order'])

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title float-none">{{ __('General Information') }}</h3>
        <div class="ml-auto">
            <a
                href="{{ route('orders.general-information.edit', $order) }}">{{ __('Edit') }}</a>
        </div>
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
