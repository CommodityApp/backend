<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\RawResource;
use App\Models\Raw;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class RawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receipts = QueryBuilder::for(Raw::class)
            ->allowedFilters('name', 'code', 'unit', 'concentration', 'batch_number')
            ->allowedSorts('id', 'name', 'code')
            ->allowedIncludes('lastRawPrice', 'rawType', 'bunker', 'country', 'rawPrices', 'producer')
            ->paginate();

        return RawResource::collection($receipts);
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
