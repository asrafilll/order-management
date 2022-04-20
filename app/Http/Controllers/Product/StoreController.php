<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        dd($storeRequest->all());
    }
}
