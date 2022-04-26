<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipping\UpdateRequest;
use App\Models\Shipping;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param Shipping $shipping
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Shipping $shipping, UpdateRequest $updateRequest)
    {
        $shipping->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'shipping',
        ]);

        return Response::redirectToRoute('shippings.edit', $shipping)
            ->with('success', $message);
    }
}
