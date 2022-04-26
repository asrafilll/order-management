<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Response;

class EditController extends Controller
{
    /**
     * @param PaymentMethod $paymentMethod
     * @return \Illuminate\Http\Response
     */
    public function __invoke(PaymentMethod $paymentMethod)
    {
        return Response::view('payment-methods.edit', [
            'paymentMethod' => $paymentMethod,
        ]);
    }
}
