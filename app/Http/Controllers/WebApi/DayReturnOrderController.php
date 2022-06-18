<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\DayReturnOrderResource;
use App\Models\ReturnOrder;
use Illuminate\Http\Request;

class DayReturnOrderController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return DayReturnOrderResource::collection(
            ReturnOrder::query()
                ->selectRaw('DATE(created_at) as date, COUNT(id) as total')
                ->when($request->filled('start_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(created_at) >= ?', [$request->get('start_date')]);
                })
                ->when($request->filled('end_date'), function ($query) use ($request) {
                    $query->whereRaw('DATE(created_at) <= ?', [$request->get('end_date')]);
                })
                ->groupByRaw('YEAR(created_at), MONTH(created_at), DAY(created_at), date')
                ->orderBy('date')
                ->get()
        );
    }
}
