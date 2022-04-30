<?php

namespace App\Http\Controllers\Order\ShippingDetail;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\ShippingDetail\UpdateRequest;
use App\Models\Order;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param Order $order
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Order $order, UpdateRequest $updateRequest)
    {
        $order->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'shipping detail',
        ]);

        return Response::redirectToRoute('orders.edit', $order)
            ->with('success', $message);
    }
}
