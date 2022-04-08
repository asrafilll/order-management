<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class DestroyController extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user)
    {
        abort_if(Auth::id() == $user->id, \Illuminate\Http\Response::HTTP_FORBIDDEN);

        $user->delete();

        return Response::redirectToRoute('users.index')
            ->with('success', __('crud.deleted', [
                'name' => 'user',
            ]));
    }
}
