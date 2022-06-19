<?php

namespace App\Http\Controllers\Order\Bulk\Print;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        /** @var Collection<Order> */
        $orders = Order::with(['items'])
            ->whereIn('id', $request->get('ids'))
            ->latest()
            ->get();

        $company = [
            'name' => Meta::findByKey('company_name'),
            'phone' => Meta::findByKey('company_phone'),
            'address' => Meta::findByKey('company_address'),
            'province' => Meta::findByKey('company_province'),
            'city' => Meta::findByKey('company_city'),
            'subdistrict' => Meta::findByKey('company_subdistrict'),
            'village' => Meta::findByKey('company_village'),
            'postal_code' => Meta::findByKey('company_postal_code'),
        ];

        $companyAddress = Collection::make();
        $companyAddressFields = [
            'village',
            'subdistrict',
            'city',
            'province',
            'postal_code',
        ];

        foreach ($companyAddressFields as $field) {
            if (isset($company[$field]) && !is_null($company[$field])) {
                $companyAddress->push($company[$field]);
            }
        }

        $companyAddress = $companyAddress->join(', ');

        return Pdf::loadView('orders.bulk.print.index', [
            'orders' => $orders,
            'company' => $company,
            'companyAddress' => $companyAddress
        ])->stream('orders.pdf');
    }
}
