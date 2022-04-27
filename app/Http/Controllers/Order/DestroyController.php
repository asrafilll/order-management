<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Order $order)
    {
        $order->delete();
        $message = __('crud.deleted', [
            'name' => 'order',
        ]);

        return Response::redirectToRoute('orders.index')
            ->with('success', $message);
    }
}
