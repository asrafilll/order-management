<?php

namespace App\Http\Controllers\ReturnOrder;

use App\Http\Controllers\Controller;
use App\Models\ReturnOrder;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param ReturnOrder $returnOrder
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ReturnOrder $returnOrder)
    {
        $returnOrder->delete();
        $message = __('crud.deleted', [
            'name' => 'return order',
        ]);

        return Response::redirectToRoute('return-orders.index')
            ->with('success', $message);
    }
}
