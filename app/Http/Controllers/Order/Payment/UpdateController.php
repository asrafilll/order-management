<?php

namespace App\Http\Controllers\Order\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\Payment\UpdateRequest;
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
            'name' => 'payment method',
        ]);

        return Response::redirectToRoute('orders.edit', $order)
            ->with('success', $message);
    }
}
