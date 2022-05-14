<?php

namespace App\Http\Controllers\Order\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\Item\UpdateRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param Order $order
     * @param OrderItem $orderItem
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(
        Order $order,
        OrderItem $orderItem,
        UpdateRequest $updateRequest
    ) {
        abort_unless($order->id == $orderItem->order_id, HttpResponse::HTTP_FORBIDDEN);

        $orderItem->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'order item',
        ]);

        return Response::redirectToRoute('orders.edit', $order)
            ->with('success', $message);
    }
}
