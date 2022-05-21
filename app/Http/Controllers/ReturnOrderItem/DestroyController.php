<?php

namespace App\Http\Controllers\ReturnOrderItem;

use App\Http\Controllers\Controller;
use App\Models\ReturnOrderItem;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param ReturnOrderItem $returnOrderItem
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ReturnOrderItem $returnOrderItem)
    {
        abort_if($returnOrderItem->isPublished(), HttpResponse::HTTP_FORBIDDEN);

        $returnOrderItem->delete();
        $message = __('crud.deleted', [
            'name' => 'return order item',
        ]);

        return Response::redirectToRoute('return-order-items.index')
            ->with('success', $message);
    }
}
