<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentMethod\UpdateRequest;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param PaymentMethod $paymentMethod
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PaymentMethod $paymentMethod, UpdateRequest $updateRequest)
    {
        $paymentMethod->update($updateRequest->validated());
        $message = __('crud.updated', [
            'name' => 'payment method',
        ]);

        return Response::redirectToRoute('payment-methods.edit', $paymentMethod)
            ->with('success', $message);
    }
}
