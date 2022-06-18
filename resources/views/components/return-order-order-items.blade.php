@props(['returnOrder'])

<div>
    <div id="return-order-order-items-module">
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
                                <th>{{ __('Quantity That Can Be Returned') }}</th>
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
                                    <td>{{ $item->getUnreturnQuantity() }}</td>
                                    <td class="text-right">
                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            data-toggle="modal"
                                            data-target="#create-return-order-item-modal"
                                            data-order-item='@json($item)'
                                        >{{ __('Return') }}</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="3"
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
            id="create-return-order-item-modal"
            tabindex="-1"
        >
            <form
                action="{{ route('return-orders.items.store', $returnOrder) }}"
                method="POST"
            >
                @csrf
                <input
                    type="hidden"
                    id="create-return-order_order_item_id"
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
                                <dd id="create-return-order_order_item"></dd>
                            </dl>
                            <div class="form-group">
                                <label for="create-return-order_quantity">
                                    <span>{{ __('Quantity') }}</span>
                                    <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="create-return-order_quantity"
                                    name="quantity"
                                    min="1"
                                    class="form-control @error('quantity') is-invalid @enderror"
                                />
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="create-return-order_reason">
                                    <span>{{ __('Reason') }}</span>
                                </label>
                                <input
                                    type="text"
                                    id="create-return-order_reason"
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
        const ReturnOrderOrderItems = (function() {
            const $el = $('#return-order-order-items-module');
            const $createModal = $el.find('#create-return-order-item-modal');
            const $createForm = $createModal.find('form');
            const $orderItemId = $createForm.find('#create-return-order_order_item_id');
            const $orderItem = $createForm.find('#create-return-order_order_item');

            $createModal.on('show.bs.modal', handleShowModal)

            function handleShowModal(event) {
                const $btn = $(event.relatedTarget);
                const orderItem = $btn.data('order-item');
                $orderItemId.val(orderItem.id);
                $orderItem.text(`${orderItem.product_name} - ${orderItem.variant_name}`);
            }
        })();
    </script>
</div>
