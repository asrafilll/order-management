<?php

namespace App\Http\Controllers\ReturnOrder\Status;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnOrder\Status\UpdateRequest;
use App\Models\ReturnOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param ReturnOrder $returnOrder
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ReturnOrder $returnOrder, UpdateRequest $updateRequest)
    {
        $returnOrder->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'return order status',
        ]);

        return Response::redirectToRoute('return-orders.edit', $returnOrder)
            ->with('success', $message);
    }
}
