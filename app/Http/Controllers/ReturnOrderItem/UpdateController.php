<?php

namespace App\Http\Controllers\ReturnOrderItem;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnOrderItem\UpdateRequest;
use App\Models\OrderItem;
use App\Models\ReturnOrderItem;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;

class UpdateController extends Controller
{
    /**
     * @param ReturnOrderItem $customer
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ReturnOrderItem $returnOrderItem, UpdateRequest $updateRequest)
    {
        abort_if($returnOrderItem->isPublished(), HttpResponse::HTTP_FORBIDDEN);

        /** @var OrderItem */
        $orderItem = OrderItem::find($returnOrderItem->order_item_id);
        $maxQuantity = $orderItem->quantity - ReturnOrderItem::query()
            ->whereOrderId($returnOrderItem->order_id)
            ->whereOrderItemId($returnOrderItem->order_item_id)
            ->where('id', '!=', $returnOrderItem->id)
            ->sum('quantity');

        if ($maxQuantity < 0) {
            return Response::redirectToRoute('return-order-items.edit', $returnOrderItem)
                ->with('error', __("Can't update new return order item."));
        }

        if ($updateRequest->get('quantity') > $maxQuantity) {
            throw ValidationException::withMessages([
                'quantity' => __('validation.max.numeric', [
                    'attribute' => 'quantity',
                    'max' => $maxQuantity,
                ]),
            ]);
        }

        $returnOrderItem->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'return order item',
        ]);

        if ($returnOrderItem->isPublished()) {
            return Response::redirectToRoute('return-order-items.index')
                ->with('success', $message);
        }

        return Response::redirectToRoute('return-order-items.edit', $returnOrderItem)
            ->with('success', $message);
    }
}
