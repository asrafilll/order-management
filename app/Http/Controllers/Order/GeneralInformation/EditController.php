<?php

namespace App\Http\Controllers\Order\GeneralInformation;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Response;

class EditController extends Controller
{
    /**
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Order $order)
    {
        abort_unless($order->isEditable(), HttpResponse::HTTP_FORBIDDEN);

        return Response::view('orders.general-information.edit', [
            'order' => $order,
        ]);
    }
}
