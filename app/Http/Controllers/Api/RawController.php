<?php

namespace App\Http\Controllers\Api;

use App\Filters\SearchFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Raw\CreateRawRequest;
use App\Http\Requests\Api\Raw\UpdateRawRequest;
use App\Http\Resources\Api\RawResource;
use App\Models\Raw;
use App\Services\RawService;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RawController extends Controller
{
    public function __construct(public RawService $rawService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receipts = QueryBuilder::for(Raw::class)
            ->allowedFilters(
                'name',
                'code',
                'unit',
                'concentration',
                'batch_number',
                AllowedFilter::custom('search', new SearchFilter(['name', 'code', 'unit', 'description']))
            )
            ->allowedSorts('id', 'name', 'code')
            ->allowedIncludes('lastRawPrice', 'rawType', 'bunker', 'country', 'rawPrices', 'producer', 'firstActivity.causer')
            ->paginate(request()->input('per_page', 15));

        return RawResource::collection($receipts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRawRequest $request)
    {
        $raw = $this->rawService->create($request->safe()->only([
            'code',
            'name',
            'unit',
            'description',
            'concentration',
            'batch_number',
            'producer_id',
            'country_id',
            'raw_type_id',
            'bunker_id',
        ]));

        return new RawResource($raw->load('rawType', 'bunker', 'country', 'rawPrices', 'producer'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Raw $raw)
    {
        return new RawResource($raw->load('rawType', 'bunker', 'country', 'rawPrices', 'producer', 'activities.causer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRawRequest $request, Raw $raw)
    {
        $raw = $this->rawService->update($raw, $request->safe()->only([
            'code',
            'name',
            'unit',
            'description',
            'concentration',
            'batch_number',
            'producer_id',
            'country_id',
            'raw_type_id',
            'bunker_id',
        ]));

        return new RawResource($raw->load('rawType', 'bunker', 'country', 'rawPrices', 'producer'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Raw $raw)
    {
        $raw = $this->rawService->delete($raw);

        return $raw->id;
    }
}
