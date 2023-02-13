<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityOrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class CityOrderController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return CityOrderResource::collection(
            Order::query()
                ->selectRaw('customer_city as city, COUNT(id) as total')
                ->when($request->filled('start_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(closing_date) >= ?', [$request->get('start_date')]);
                })
                ->when($request->filled('end_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(closing_date) <= ?', [$request->get('end_date')]);
                })
                ->groupBy('customer_city')
                ->get()
        );
    }
}
