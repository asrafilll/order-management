<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
        $customers = Customer::query()
            ->paginate(
                perPage: $request->get('per_page', 10),
                page: $request->get('page')
            );

        return Response::view('customers.index', [
            'customers' => $customers,
        ]);
    }
}
