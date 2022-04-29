<?php

namespace App\Http\Controllers\Order\ItemsDiscount;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\ItemsDiscount\UpdateRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param Order $order
     * @param UpdateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Order $order, UpdateRequest $updateRequest)
    {
        $order->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'items discount',
        ]);

        return Response::redirectToRoute('orders.edit', $order)
            ->with('succes', $message);
    }
}
