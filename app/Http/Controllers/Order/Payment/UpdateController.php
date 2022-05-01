<?php

namespace App\Http\Controllers\Order\Payment;

use App\Enums\OrderHistoryTypeEnum;
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
        $currentPaymentStatus = $order->payment_status;
        $order->update($updateRequest->validated());

        if ($currentPaymentStatus !== $updateRequest->get('payment_status')) {
            $order->histories()->create([
                'type' => OrderHistoryTypeEnum::payment_status(),
                'from' => $currentPaymentStatus,
                'to' => $updateRequest->get('payment_status'),
            ]);
        }

        $message = __('crud.updated', [
            'name' => 'payment',
        ]);

        return Response::redirectToRoute('orders.edit', $order)
            ->with('success', $message);
    }
}
