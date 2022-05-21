<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return OrderResource::collection(
            Order::query()
                ->when($request->filled('q'), function ($query) use ($request) {
                    $query->where('id', 'LIKE', '%' . $request->get('q') . '%');
                })
                ->when($request->filled('status'), function ($query) use ($request) {
                    $query->where('status', $request->get('status'));
                })
                ->paginate(
                    perPage: $request->get('per_page', 10),
                    page: $request->get('page')
                )
        );
    }
}
