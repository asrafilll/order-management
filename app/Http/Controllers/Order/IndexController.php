<?php

namespace App\Http\Controllers\Order;

use App\Actions\CreateOrdersQueryFromRequestAction;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    /**
     * @param CreateOrdersQueryFromRequestAction $createOrdersQueryFromRequestAction
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(
        CreateOrdersQueryFromRequestAction $createOrdersQueryFromRequestAction,
        Request $request
    ) {
        $query = $createOrdersQueryFromRequestAction->run($request);

        if ($request->get('action') === 'export') {
            return new OrdersExport($query);
        }

        return Response::view('orders.index', [
            'orders' => $query->paginate(
                perPage: $request->get('per_page', 10),
                page: $request->get('page')
            ),
        ]);
    }
}
