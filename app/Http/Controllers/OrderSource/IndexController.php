<?php

namespace App\Http\Controllers\OrderSource;

use App\Http\Controllers\Controller;
use App\Models\OrderSource;
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
        $orderSources = OrderSource::query()
            ->select([
                'order_sources.*',
                'parent.name as parent_name',
            ])
            ->leftJoin('order_sources as parent', 'order_sources.parent_id', 'parent.id')
            ->latest()
            ->paginate(
                perPage: $request->get('per_page', 10),
                page: $request->get('page')
            );

        return Response::view('order-sources.index', [
            'orderSources' => $orderSources,
        ]);
    }
}
