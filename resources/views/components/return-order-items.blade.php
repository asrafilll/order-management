@props(['returnOrder'])

<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('Returned') }}</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive border-bottom">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Quantity') }}</th>
                        <th>{{ __('Reason') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($returnOrder->items as $item)
                        <tr>
                            <td>
                                <dl>
                                    <dt>{{ $item->orderItem->product_name }}</dt>
                                    <dd>
                                        <ul class="list-unstyled">
                                            <li>{{ $item->orderItem->variant_name }}</li>
                                            <li>
                                                {{ Config::get('app.currency') . ' ' . number_format($item->orderItem->variant_price) }}
                                            </li>
                                        </ul>
                                    </dd>
                                </dl>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->reason }}</td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <button
                                        class="btn btn-light"
                                        type="button"
                                        data-toggle="dropdown"
                                    >
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a
                                            class="dropdown-item"
                                            href="#"
                                        >{{ __('Edit') }}</a>
                                        <button
                                            type="button"
                                            class="dropdown-item text-danger"
                                            data-toggle="modal"
                                            data-target="#modal-delete"
                                            data-action="#"
                                        >{{ __('Delete') }}</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="4"
                                class="text-center"
                            >{{ __('Data not found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
