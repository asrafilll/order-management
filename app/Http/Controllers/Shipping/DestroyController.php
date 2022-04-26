<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param Shipping $shipping
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Shipping $shipping)
    {
        $shipping->delete();
        $message = __('crud.deleted', [
            'name' => 'shipping',
        ]);

        return Response::redirectToRoute('shippings.index')
            ->with('success', $message);
    }
}
