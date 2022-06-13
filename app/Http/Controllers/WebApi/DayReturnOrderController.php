<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\DayReturnOrderResource;
use App\Models\ReturnOrder;
use Illuminate\Http\Request;

class DayReturnOrderController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return DayReturnOrderResource::collection(
            ReturnOrder::query()
                ->selectRaw('ANY_VALUE(DATE(created_at)) as date, COUNT(id) as total')
                ->groupByRaw('YEAR(created_at), MONTH(created_at), DAY(created_at)')
                ->orderBy('date')
                ->get()
        );
    }
}
