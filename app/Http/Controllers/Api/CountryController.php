<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = QueryBuilder::for(Country::class)
            ->allowedFilters('name', 'country_code', 'iso_3166_2', 'iso_3166_3')
            ->allowedSorts('id', 'name')
            ->paginate(request()->input('per_page', 15));

        return CountryResource::collection($countries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
