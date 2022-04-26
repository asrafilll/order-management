<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethod\StoreRequest;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        $paymentMethod = PaymentMethod::create($storeRequest->validated());
        $message = __('crud.created', [
            'name' => 'payment method',
        ]);

        return Response::redirectToRoute('payment-methods.edit', $paymentMethod)
            ->with('success', $message);
    }
}
