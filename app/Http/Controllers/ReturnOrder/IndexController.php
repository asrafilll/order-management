<?php

namespace App\Http\Controllers\ReturnOrder;

use App\Http\Controllers\Controller;
use App\Models\ReturnOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return Response::view('return-orders.index', [
            'returnOrders' => ReturnOrder::query()
                ->latest()
                ->paginate($request->get('per_page', 10)),
        ]);
    }
}
