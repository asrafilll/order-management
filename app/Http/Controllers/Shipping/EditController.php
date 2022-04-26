<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Support\Facades\Response;

class EditController extends Controller
{
    /**
     * @param Shipping $shipping
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Shipping $shipping)
    {
        return Response::view('shippings.edit', [
            'shipping' => $shipping,
        ]);
    }
}
