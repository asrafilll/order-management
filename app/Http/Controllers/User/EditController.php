<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class EditController extends Controller
{
    /**
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user)
    {
        return Response::view('users.edit', [
            'user' => $user,
            'roles' => Role::all(),
        ]);
    }
}
