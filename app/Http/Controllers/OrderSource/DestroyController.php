<?php

namespace App\Http\Controllers\OrderSource;

use App\Http\Controllers\Controller;
use App\Models\OrderSource;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param OrderSource $orderSource
     * @return \Illuminate\Http\Response
     */
    public function __invoke(OrderSource $orderSource)
    {
        $orderSource->delete();
        $message = __('crud.deleted', [
            'name' => 'order source',
        ]);

        return Response::redirectToRoute('order-sources.index')
            ->with('success', $message);
    }
}
