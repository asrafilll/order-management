<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class StoreController extends Controller
{
    /**
     * @param StoreRequest $storeRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreRequest $storeRequest)
    {
        DB::transaction(function () use ($storeRequest) {
            /** @var User */
            $user = User::create($storeRequest->safe()->only([
                'name',
                'email',
                'password',
            ]));

            $user->assignRole($storeRequest->get('role'));
        });

        $message = __('crud.created', [
            'name' => 'user'
        ]);

        return Response::redirectToRoute('users.index')
            ->with('success', $message);
    }
}
