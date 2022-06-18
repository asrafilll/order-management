<?php

namespace App\Http\Controllers\ReturnOrder;

use App\Http\Controllers\Controller;
use App\Models\ReturnOrder;
use App\Models\ReturnOrderItem;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param ReturnOrder $returnOrder
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ReturnOrder $returnOrder)
    {
        $returnOrder->items
            ->each(fn (ReturnOrderItem $returnOrderItem) => $returnOrderItem->delete());
        $returnOrder->delete();
        $message = __('crud.deleted', [
            'name' => 'return order',
        ]);

        return Response::redirectToRoute('return-orders.index')
            ->with('success', $message);
    }
}
