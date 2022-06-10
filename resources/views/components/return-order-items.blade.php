@props(['returnOrder'])

<div>
    <div id="return-order-items-module">
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
                                                <button
                                                    type="button"
                                                    class="dropdown-item"
                                                    data-toggle="modal"
                                                    data-target="#edit-return-order-item-modal"
                                                    data-action="{{ route('return-orders.items.update', ['returnOrder' => $returnOrder, 'returnOrderItem' => $item]) }}"
                                                    data-item='@json($item)'
                                                >{{ __('Edit') }}</button>
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
        <div
            class="modal fade"
            id="edit-return-order-item-modal"
            tabindex="-1"
        >
            <form method="POST">
                @csrf
                @method('PUT')
                <input
                    type="hidden"
                    id="order_item_id"
                    name="order_item_id"
                />
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Return Order Item') }}</h5>
                            <button
                                type="button"
                                class="close"
                                data-dismiss="modal"
                                aria-label="Close"
                            >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <dl>
                                <dt>{{ __('Item') }}</dt>
                                <dd id="edit-return-order-item_order_item"></dd>
                            </dl>
                            <div class="form-group">
                                <label for="edit-return-order-item_quantity">
                                    <span>{{ __('Quantity') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="edit-return-order-item_quantity"
                                    name="quantity"
                                    min="1"
                                    class="form-control @error('quantity') is-invalid @enderror"
                                />
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="edit-return-order-item_reason">
                                    <span>{{ __('Reason') }}</span>
                                </label>
                                <input
                                    type="text"
                                    id="edit-return-order-item_reason"
                                    name="reason"
                                    class="form-control @error('reason') is-invalid @enderror"
                                />
                                @error('reason')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >{{ __('Back') }}</button>
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >{{ __('Save') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        const ReturnOrderItems = (function() {
            const $el = $('#return-order-items-module');
            const $editModal = $el.find('#edit-return-order-item-modal');
            const $form = $editModal.find('form');
            const $orderItem = $form.find('#edit-return-order-item_order_item');
            const $quantity = $form.find('#edit-return-order-item_quantity');
            const $reason = $form.find('#edit-return-order-item_reason');

            $editModal.on('show.bs.modal', handleShowModal);

            function handleShowModal(event) {
                const $btn = $(event.relatedTarget);
                const item = $btn.data('item');
                const action = $btn.data('action');

                $form.attr('action', action);
                $orderItem.text(`${item.order_item.product_name} - ${item.order_item.variant_name}`);
                $quantity.val(item.quantity);
                $reason.val(item.reason);
            }
        })();
    </script>
</div>
