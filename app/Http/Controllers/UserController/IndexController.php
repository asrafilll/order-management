<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

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
        $users = User::query()
            ->when(
                $request->filled('search'),
                function (Builder $query) use ($request) {
                    $query->where(function (Builder $query) use ($request) {
                        $value = '%' . $request->get('search') . '%';
                        $query
                            ->orWhere('name', 'LIKE', $value)
                            ->orWhere('email', 'LIKE', $value);
                    });
                }
            )
            ->paginate(
                perPage: $request->get('per_page', 10),
                page: $request->get('page', 1)
            );

        if ($request->wantsJson()) {
            return UserResource::collection($users);
        }

        return Response::view('users.index', [
            'users' => $users,
        ]);
    }
}