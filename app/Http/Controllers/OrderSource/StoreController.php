<?php

namespace App\Http\Controllers\OrderSource;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderSource\StoreRequest;
use App\Models\OrderSource;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        $orderSource = OrderSource::create($storeRequest->validated());
        $message = __('crud.created', [
            'name' => 'order source',
        ]);

        return Response::redirectToRoute('order-sources.edit', $orderSource)
            ->with('success', $message);
    }
}
