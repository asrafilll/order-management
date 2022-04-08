<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Models\Role;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        Role::create($storeRequest->validated());
        $message = __('crud.created', [
            'name' => 'role',
        ]);

        return Response::redirectToRoute('roles.index')
            ->with('success', $message);
    }
}
