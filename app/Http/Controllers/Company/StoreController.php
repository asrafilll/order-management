<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreRequest;
use App\Models\Meta;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        foreach ($storeRequest->validated() as $key => $value) {
            Meta::createOrUpdate('company_' . $key, $value);
        }

        $message = __('crud.updated', [
            'name' => 'company',
        ]);

        return Response::redirectToRoute('company.index')
            ->with('success', $message);
    }
}
