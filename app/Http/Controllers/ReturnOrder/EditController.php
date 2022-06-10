<?php

namespace App\Http\Controllers\ReturnOrder;

use App\Enums\ReturnOrderStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\ReturnOrder;
use Illuminate\Support\Facades\Response;

class EditController extends Controller
{
    /**
     * @param ReturnOrder $returnOrder
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ReturnOrder $returnOrder)
    {
        $returnOrder->load(['order', 'items.orderItem']);

        return Response::view('return-orders.edit', [
            'returnOrder' => $returnOrder,
            'returnOrderStatuses' => ReturnOrderStatusEnum::toValues(),
        ]);
    }
}
