@props(['returnOrder'])

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Items') }}</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive border-bottom">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($returnOrder->order->items as $item)
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
                            <td>{{ $item->quantity }}</td>
                            <td class="text-right">
                                <a
                                    href="#"
                                    class="btn btn-primary"
                                >{{ __('Return') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="2"
                                class="text-center"
                            >{{ __('Data not found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
