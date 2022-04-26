<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipping\StoreRequest;
use App\Models\Shipping;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        $shipping = Shipping::create($storeRequest->validated());
        $message = __('crud.created', [
            'name' => 'shipping',
        ]);

        return Response::redirectToRoute('shippings.edit', $shipping)
            ->with('success', $message);
    }
}
