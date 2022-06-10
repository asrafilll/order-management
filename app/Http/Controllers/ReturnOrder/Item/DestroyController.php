<?php

namespace App\Http\Controllers\ReturnOrder\Item;

use App\Http\Controllers\Controller;
use App\Models\ReturnOrder;
use App\Models\ReturnOrderItem;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param ReturnOrder $returnOrder
     * @param ReturnOrderItem $returnOrderItem
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ReturnOrder $returnOrder, ReturnOrderItem $returnOrderItem)
    {
        abort_unless(intval($returnOrder->id) === intval($returnOrderItem->return_order_id), HttpResponse::HTTP_BAD_REQUEST);

        $returnOrderItem->delete();
        $message = __('crud.deleted', [
            'name' => 'return order item',
        ]);

        return Response::redirectToRoute('return-orders.edit', $returnOrder)
            ->with('success', $message);
    }
}
