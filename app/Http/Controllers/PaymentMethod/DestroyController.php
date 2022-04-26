<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param PaymentMethod $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        $message = __('crud.deleted', [
            'name' => 'payment method',
        ]);

        return Response::redirectToRoute('payment-methods.index')
            ->with('success', $message);
    }
}
