<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Meta;
use Illuminate\Support\Facades\Response;

class IndexController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        return Response::view('company.index', [
            'name' => Meta::findByKey('company_name'),
            'phone' => Meta::findByKey('company_phone'),
            'address' => Meta::findByKey('company_address'),
            'province' => Meta::findByKey('company_province'),
            'city' => Meta::findByKey('company_city'),
            'subdistrict' => Meta::findByKey('company_subdistrict'),
            'village' => Meta::findByKey('company_village'),
            'postalCode' => Meta::findByKey('company_postal_code'),
        ]);
    }
}
