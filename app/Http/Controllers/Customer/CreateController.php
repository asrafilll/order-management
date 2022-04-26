<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class CreateController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return Response::view('customers.create');
    }
}
