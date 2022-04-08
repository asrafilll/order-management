<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        User::create($storeRequest->validated());
        $message = __('crud.created', [
            'name' => 'user'
        ]);

        return Response::redirectToRoute('users.index')
            ->with('success', $message);
    }
}
