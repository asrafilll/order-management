<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubdistrictResource;
use App\Models\Subdistrict;
use Illuminate\Http\Request;

class SubdistrictController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return SubdistrictResource::collection(
            Subdistrict::query()
                ->when($request->filled('q'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->get('q') . '%');
                })
                ->when($request->filled('city_code'), function ($query) use ($request) {
                    $query->whereParent($request->get('city_code'));
                })
                ->paginate(
                    perPage: $request->get('per_page', 10),
                    page: $request->get('page')
                )
        );
    }
}
