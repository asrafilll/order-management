<?php

namespace App\Http\Controllers\WebApi;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return CityResource::collection(
            City::query()
                ->when($request->filled('q'), function ($query) use ($request) {
                    $query->where('name', 'LIKE', '%' . $request->get('q') . '%');
                })
                ->when($request->filled('province_code'), function ($query) use ($request) {
                    $query->whereParent($request->get('province_code'));
                })
                ->paginate(
                    perPage: $request->get('per_page', 10),
                    page: $request->get('page')
                )
        );
    }
}
