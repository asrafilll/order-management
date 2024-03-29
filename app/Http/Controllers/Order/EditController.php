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

        return Response::view('orders.edit', [
            'order' => $order,
            'orderStatuses' => OrderStatusEnum::toValues(),
        ]);
    }
}
