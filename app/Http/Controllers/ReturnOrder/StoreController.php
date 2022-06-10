<?php

namespace App\Http\Controllers\ReturnOrder;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReturnOrder\StoreRequest;
use App\Models\ReturnOrder;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        ReturnOrder::create($storeRequest->validated());
        $message = __('crud.created', [
            'name' => 'return order',
        ]);

        return Response::redirectToRoute('return-orders.create')
            ->with('success', $message);
    }
}
