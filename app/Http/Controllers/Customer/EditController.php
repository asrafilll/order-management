<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Response;

class EditController extends Controller
{
    /**
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Customer $customer)
    {
        return Response::view('customers.edit', [
            'customer' => $customer,
        ]);
    }
}
