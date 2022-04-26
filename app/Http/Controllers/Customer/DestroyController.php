<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Customer $customer)
    {
        $customer->delete();
        $message = __('crud.deleted', [
            'name' => 'customer',
        ]);

        return Response::redirectToRoute('customers.index')
            ->with('success', $message);
    }
}
