<?php

namespace App\Http\Controllers\OrderSource;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderSource\UpdateRequest;
use App\Models\OrderSource;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param OrderSource $orderSource
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(OrderSource $orderSource, UpdateRequest $updateRequest)
    {
        $orderSource->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'order source',
        ]);

        return Response::redirectToRoute('order-sources.edit', $orderSource)
            ->with('success', $message);
    }
}
