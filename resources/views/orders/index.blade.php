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
                            data-toggle="modal"
                            data-target="#filter-modal"
                        >{{ __('Filter') }}</button>
                        <a
                            href="{{ request()->fullUrlWithQuery(['action' => 'export']) }}"
                            class="btn btn-default"
                        >{{ __('Export') }}</a>
                    </div>
                </div>
                <div
                    class="modal fade"
                    id="filter-modal"
                    tabindex="-1"
                >
                    <div class="modal-dialog">
                        <form
                            id="filter-order-module"
                            action=""
                            method="GET"
                        >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ __('Filter') }}</h5>
                                    <button
                                        type="button"
                                        class="close"
                                        data-dismiss="modal"
                                        aria-label="Close"
                                    >
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body ui-front">
                                    <div class="form-group">
                                        <label for="customer_name">{{ __('Customer') }}</label>
                                        <input
                                            type="hidden"
                                            name="customer_id"
                                            id="customer_id"
                                            value="{{ Request::get('customer_id') }}"
                                        />
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                name="customer_name"
                                                id="customer_name"
                                                class="form-control"
                                                value="{{ Request::get('customer_name') }}"
                                            />
                                            <div class="input-group-append">
                                                <button
                                                    type="button"
                                                    class="btn btn-default btn-reset"
                                                    @if (!Request::filled('customer_name') || !Request::filled('customer_id')) disabled @endif
                                                >{{ __('Reset') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">{{ __('Status') }}</label>
                                        <div class="input-group">
                                            <select
                                                name="status"
                                                id="status"
                                                class="form-control"
                                            >
                                                <option value="">ALL</option>
                                                @foreach (\App\Enums\OrderStatusEnum::toValues() as $status)
                                                    <option
                                                        value="{{ $status }}"
                                                        @if (Request::get('status') == $status) selected @endif
                                                    >{{ Str::upper($status) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button
                                                    type="button"
                                                    class="btn btn-default btn-reset"
                                                    @if (!Request::filled('status')) disabled @endif
                                                >{{ __('Reset') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_status">{{ __('Payment Status') }}</label>
                                        <div class="input-group">
                                            <select
                                                name="payment_status"
                                                id="payment_status"
                                                class="form-control"
                                            >
                                                <option value="">ALL</option>
                                                @foreach (\App\Enums\PaymentStatusEnum::toValues() as $paymentStatus)
                                                    <option
                                                        value="{{ $paymentStatus }}"
                                                        @if (Request::get('payment_status') == $paymentStatus) selected @endif
                                                    >{{ Str::upper($paymentStatus) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button
                                                    type="button"
                                                    class="btn btn-default btn-reset"
                                                    @if (!Request::filled('payment_status')) disabled @endif
                                                >{{ __('Reset') }}</button>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="source_name">{{ __('Source') }}</label>
                                        <input
                                            type="hidden"
                                            name="source_id"
                                            id="source_id"
                                            value="{{ Request::get('source_id') }}"
                                        />
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                name="source_name"
                                                id="source_name"
                                                class="form-control"
                                                value="{{ Request::get('source_name') }}"
                                            />
                                            <div class="input-group-append">
                                                <button
                                                    type="button"
                                                    class="btn btn-default btn-reset"
                                                    @if (!Request::filled('source_name') || !Request::filled('source_id')) disabled @endif
                                                >{{ __('Reset') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a
                                        href="{{ route('orders.index') }}"
                                        class="btn btn-default"
                                    >{{ __('Reset') }}</a>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >{{ __('Apply') }}</button>
                                </div>
                            </div>
                        </form>
                        <script>
                            const FilterOrder = (function() {
                                const $el = $('#filter-order-module');
                                const $customerId = $el.find('#customer_id');
                                const $customerName = $el.find('#customer_name');
                                const $sourceId = $el.find('#source_id');
                                const $sourceName = $el.find('#source_name');
                                const $resets = $el.find('.btn-reset');

                                $resets.on('click', handleReset);

                                init();

                                function handleReset() {
                                    const $this = $(this);
                                    const $formGroup = $this.closest('.form-group');
                                    const $inputs = $formGroup.find('input, select');
                                    $inputs
                                        .toArray()
                                        .forEach(function(element) {
                                            const $this = $(element);
                                            $this.val(null);
                                        });
                                    $this.attr('disabled', true);
                                }

                                function init() {
                                    $customerName.autocomplete({
                                        source: function(request, response) {
                                            $.ajax({
                                                method: 'GET',
                                                url: '{{ route('web-api.customers.index') }}',
                                                data: {
                                                    q: request.term,
                                                },
                                                success: function(res) {
                                                    response(res.data.map(function(customer) {
                                                        return {
                                                            id: customer.id,
                                                            label: customer.name,
                                                            value: customer.name,
                                                        };
                                                    }))
                                                },
                                            });
                                        },
                                        select: function(event, ui) {
                                            $customerId.val(ui.item.id);
                                        },
                                        change: function(event, ui) {
                                            console.log(ui);
                                            $customerId.val(ui.item ? ui.item.id : null);
                                        }
                                    });

                                    $sourceName.autocomplete({
                                        source: function(request, response) {
                                            $.ajax({
                                                method: 'GET',
                                                url: '{{ route('web-api.order-sources.index') }}',
                                                data: {
                                                    q: request.term,
                                                },
                                                success: function(res) {
                                                    response(res.data.map(function(orderSource) {
                                                        return {
                                                            id: orderSource.id,
                                                            label: orderSource.name,
                                                            value: orderSource.name,
                                                        };
                                                    }))
                                                },
                                            });
                                        },
                                        select: function(event, ui) {
                                            $sourceId.val(ui.item.id);
                                        },
                                    })
                                }
                            })();
                        </script>
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
