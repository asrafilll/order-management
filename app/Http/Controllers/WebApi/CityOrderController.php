<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityOrderResource;
use App\Models\Order;

class CityOrderController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return CityOrderResource::collection(
            Order::query()
                ->selectRaw('customer_city as city, COUNT(id) as total')
                ->groupBy('customer_city')
                ->get()
        );
    }
}
