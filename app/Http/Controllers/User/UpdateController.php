<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class UpdateController extends Controller
{
    /**
     * @param User @user
     * @param UpdateRequest $updateRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user, UpdateRequest $updateRequest)
    {
        $user->update($updateRequest->validated());
        $message = __('crud.updated', ['name' => 'user']);

        return Response::redirectToRoute('users.edit', $user)
            ->with('success', $message);
    }
}
