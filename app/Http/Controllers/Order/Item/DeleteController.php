<?php

namespace App\Http\Controllers\Order\Item;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class DeleteController extends Controller
{
    /**
     * @param Order $order
     * @param OrderItem $orderItem
     * @return \Illuminate\Http\Response
     */
    public function __invoke(
        Order $order,
        OrderItem $orderItem,
    ) {
        abort_unless($order->id === $orderItem->order_id, HttpResponse::HTTP_FORBIDDEN);

        $orderItem->delete();
        $message = __('crud.deleted', [
            'name' => 'order item',
        ]);

        return Response::redirectToRoute('orders.edit', $order)
            ->with('success', $message);
    }
}
