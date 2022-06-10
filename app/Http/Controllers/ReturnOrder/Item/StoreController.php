<?php

namespace App\Http\Controllers\ReturnOrder\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnOrder\Item\StoreRequest;
use App\Models\ReturnOrder;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param ReturnOrder $returnOrder
     * @param StoreRequest $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ReturnOrder $returnOrder, StoreRequest $storeRequest)
    {
        $returnOrder->items()->create($storeRequest->validated());
        $message = __('crud.created', [
            'name' => 'return order item',
        ]);

        return Response::redirectToRoute('return-orders.edit', $returnOrder)
            ->with('success', $message);
    }
}
