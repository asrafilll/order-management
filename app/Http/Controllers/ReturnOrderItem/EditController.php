<?php

namespace App\Http\Controllers\ReturnOrderItem;

use App\Http\Controllers\Controller;
use App\Models\ReturnOrderItem;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class EditController extends Controller
{
    /**
     * @param ReturnOrderItem $returnOrderItem
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ReturnOrderItem $returnOrderItem)
    {
        abort_if($returnOrderItem->isPublished(), HttpResponse::HTTP_FORBIDDEN);

        $returnOrderItem->load([
            'order',
            'orderItem',
        ]);

        return Response::view('return-order-items.edit', [
            'returnOrderItem' => $returnOrderItem,
        ]);
    }
}
