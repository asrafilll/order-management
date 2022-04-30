<x-app>
    <x-content-header>
        <div>
            <h1 class="m-0">{{ __('Orders') }}</h1>
        </div>
        <div>
            <a
                href="{{ route('orders.create') }}"
                class="btn btn-primary"
            >{{ __('Create') }}</a>
        </div>
    </x-content-header>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <form
                        action=""
                        method="GET"
                        class="col-lg mb-2 mb-lg-0"
                    >
                        <div class="input-group">
                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Search here"
                                value="{{ Request::get('search') }}"
                            >

                            <div class="input-group-append">
                                <button
                                    type="submit"
                                    class="btn btn-default"
                                >
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="col-lg-auto">
                        <button
                            type="button"
                            class="btn btn-default"
                        >{{ __('Filter') }}</button>
                        <button
                            type="button"
                            class="btn btn-default"
                        >{{ __('Export') }}</button>
                    </div>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Customer') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Payment Status') }}</th>
                            <th>{{ __('Source') }}</th>
                            <th>{{ __('Items') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ Config::get('app.currency') . ' ' . number_format($order->total_price) }}</td>
                                <td>{{ Str::upper($order->status) }}</td>
                                <td>{{ Str::upper($order->payment_status) }}</td>
                                <td>{{ $order->source_name }}</td>
                                <td>{{ $order->items_quantity . ' ' . __('items') }}</td>
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
                                                href="{{ route('orders.edit', $order) }}"
                                            >{{ __('Edit') }}</a>
                                            @if ($order->isEditable())
                                                <button
                                                    type="button"
                                                    class="dropdown-item text-danger"
                                                    data-toggle="modal"
                                                    data-target="#modal-delete"
                                                    data-action="{{ route('orders.destroy', $order) }}"
                                                >{{ __('Delete') }}</button>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="9"
                                    class="text-center"
                                >{{ __('Data not found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
                {!! $orders->withQueryString()->links() !!}
            </div>
        </div>
    </section>
</x-app>
