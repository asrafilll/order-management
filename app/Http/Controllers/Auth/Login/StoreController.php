<?php

namespace App\Http\Controllers\Auth\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Login\StoreRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        $storeRequest->authenticate();
        $storeRequest->session()->regenerate();
        return Response::redirectToIntended(RouteServiceProvider::HOME);
    }
}
