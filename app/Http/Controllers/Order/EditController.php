<?php

namespace App\Http\Controllers\Order;

use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Response;

class EditController extends Controller
{
    /**
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Order $order)
    {
        $order->load([
            'items',
            'histories',
        ]);

        $orderStatuses = [];

        switch ($order->status) {
            case OrderStatusEnum::waiting():
                $orderStatuses = [
                    OrderStatusEnum::waiting()->value,
                ];

                if ($order->canProcessed()) {
                    $orderStatuses = array_merge($orderStatuses, [
                        OrderStatusEnum::processed()->value,
                    ]);
                }

                if ($order->canSent()) {
                    $orderStatuses = array_merge($orderStatuses, [
                        OrderStatusEnum::sent()->value,
                        OrderStatusEnum::completed()->value,
                        OrderStatusEnum::canceled()->value,
                    ]);
                }
                break;

            case OrderStatusEnum::processed():
                $orderStatuses = [
                    OrderStatusEnum::processed()->value,
                ];

                if ($order->canSent()) {
                    $orderStatuses = array_merge($orderStatuses, [
                        OrderStatusEnum::sent()->value,
                        OrderStatusEnum::completed()->value,
                        OrderStatusEnum::canceled()->value,
                    ]);
                }
                break;

            case OrderStatusEnum::sent():
                $orderStatuses = [
                    OrderStatusEnum::sent()->value,
                    OrderStatusEnum::completed()->value,
                    OrderStatusEnum::canceled()->value,
                ];
                break;
        }

        return Response::view('orders.edit', [
            'order' => $order,
            'orderStatuses' => $orderStatuses,
        ]);
    }
}
