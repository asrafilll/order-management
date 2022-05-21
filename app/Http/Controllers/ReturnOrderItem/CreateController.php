<?php

namespace App\Http\Controllers\ReturnOrderItem;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class CreateController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return Response::view('return-order-items.create');
    }
}
