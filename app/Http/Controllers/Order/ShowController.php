<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class ShowController extends Controller
{
    /**
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Order $order)
    {
        $order->load(['items']);

        return Pdf::loadView('orders.show-pdf', [
            'order' => $order,
        ])->stream("order_{$order->id}.pdf");
    }
}
