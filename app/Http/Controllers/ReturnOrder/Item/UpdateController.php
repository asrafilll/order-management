<?php

namespace App\Http\Controllers\ReturnOrder\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnOrder\Item\UpdateRequest;
use App\Models\ReturnOrder;
use App\Models\ReturnOrderItem;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param ReturnOrder $returnOrder
     * @param ReturnOrderItem $returnOrderItem
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(
        ReturnOrder $returnOrder,
        ReturnOrderItem $returnOrderItem,
        UpdateRequest $updateRequest
    ) {
        $returnOrderItem->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'return order item',
        ]);

        return Response::redirectToRoute('return-orders.edit', $returnOrder)
            ->with('success', $message);
    }
}
