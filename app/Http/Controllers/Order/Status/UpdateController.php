<?php

namespace App\Http\Controllers\Order\Status;

use App\Enums\OrderHistoryTypeEnum;
use App\Enums\OrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\Status\UpdateRequest;
use App\Models\Order;
use Illuminate\Http\Response as HttpResponse;
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
        $currentStatus = $order->status;
        $order->update($updateRequest->validated());

        if ($currentStatus !== $updateRequest->get('status')) {
            $order->histories()->create([
                'type' => OrderHistoryTypeEnum::status(),
                'from' => $currentStatus,
                'to' => $updateRequest->get('status'),
            ]);
        }

        $message = __('crud.updated', [
            'name' => 'status',
        ]);

        return Response::redirectToRoute('orders.edit', $order)
            ->with('success', $message);
    }
}
