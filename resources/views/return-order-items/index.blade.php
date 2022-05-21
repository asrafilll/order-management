<x-app>
    <x-content-header>
        <div>
            <h1 class="m-0">{{ __('Return Order Items') }}</h1>
        </div>
        <div>
            <a
                href="{{ route('return-order-items.create') }}"
                class="btn btn-primary"
            >{{ __('Create') }}</a>
        </div>
    </x-content-header>

    <section class="content">
        <div class="card">
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Order ID') }}</th>
                            <th>{{ __('Product') }}</th>
                            <th>{{ __('Quantity') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($returnOrderItems as $returnOrderItem)
                            <tr>
                                <td>{{ $returnOrderItem->id }}</td>
                                <td>{{ "{$returnOrderItem->order_id} ($returnOrderItem->customer_name)" }}</td>
                                <td>{{ "{$returnOrderItem->product_name} - {$returnOrderItem->variant_name}" }}</td>
                                <td>{{ $returnOrderItem->quantity }}</td>
                                <td>{{ $returnOrderItem->isPublished() ? __('PUBLISHED') : __('DRAFT') }}</td>
                                <td class="text-right">
                                    @if (!$returnOrderItem->isPublished())
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
                                                    href="{{ route('return-order-items.edit', $returnOrderItem) }}"
                                                >{{ __('Edit') }}</a>
                                                <button
                                                    type="button"
                                                    class="dropdown-item text-danger"
                                                    data-toggle="modal"
                                                    data-target="#modal-delete"
                                                    data-action="{{ route('return-order-items.destroy', $returnOrderItem) }}"
                                                >{{ __('Delete') }}</button>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="6"
                                    class="text-center"
                                >{{ __('Data not found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end">
                {!! $returnOrderItems->withQueryString()->links() !!}
            </div>
        </div>
    </section>
</x-app>
