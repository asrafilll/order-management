<?php

namespace App\Http\Controllers\ReturnOrderItem;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnOrderItem\StoreRequest;
use App\Models\OrderItem;
use App\Models\ReturnOrderItem;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        /** @var OrderItem */
        $orderItem = OrderItem::with(['order'])
            ->find($storeRequest->get('order_item_id'));
        $maxQuantity = $orderItem->quantity - ReturnOrderItem::query()
            ->whereOrderId($storeRequest->get('order_id'))
            ->whereOrderItemId($storeRequest->get('order_item_id'))
            ->sum('quantity');

        if ($maxQuantity < 1) {
            return Response::redirectToRoute('return-order-items.create')
                ->with('error', __("Can't create new return order item for item :item in order :order.", [
                    'item' => "{$orderItem->product_name} - {$orderItem->variant_name}",
                    'order' => "{$orderItem->order->id} ({$orderItem->order->customer_name})",
                ]));
        }

        if ($storeRequest->get('quantity') > $maxQuantity) {
            throw ValidationException::withMessages([
                'quantity' => __('validation.max.numeric', [
                    'attribute' => 'quantity',
                    'max' => $maxQuantity,
                ]),
            ]);
        }

        $returnOrderItem = ReturnOrderItem::create($storeRequest->validated());
        $message = __('crud.created', [
            'name' => 'return order item',
        ]);

        return Response::redirectToRoute('return-order-items.edit', $returnOrderItem)
            ->with('success', $message);
    }
}
