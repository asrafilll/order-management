<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class ShowController extends Controller
{
    /**
     * @param Order $order
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Order $order)
    {
        $order->load(['items']);
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

        $customerAddress = Collection::make([
            $order->customer_village,
            $order->customer_subdistrict,
            $order->customer_city,
            $order->customer_province,
            $order->customer_postal_code
        ])->join(', ');

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

        return Pdf::loadView('orders.show-pdf', [
            'order' => $order,
            'company' => $company,
            'customerAddress' => $customerAddress,
            'companyAddress' => $companyAddress,
        ])->stream("order_{$order->id}.pdf");
    }
}
