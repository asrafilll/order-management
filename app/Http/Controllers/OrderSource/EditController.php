<?php

namespace App\Http\Controllers\OrderSource;

use App\Http\Controllers\Controller;
use App\Models\OrderSource;
use Illuminate\Support\Facades\Response;

class EditController extends Controller
{
    /**
     * @param OrderSource $orderSource
     * @return \Illuminate\Http\Response
     */
    public function __invoke(OrderSource $orderSource)
    {
        return Response::view('order-sources.edit', [
            'orderSource' => $orderSource,
        ]);
    }
}
