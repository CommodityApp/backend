<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Ration\CreateRationRequest;
use App\Http\Requests\Api\Ration\UpdateRationRequest;
use App\Http\Resources\Api\RationResource;
use App\Models\Ration;
use App\Services\RationService;
use Spatie\QueryBuilder\QueryBuilder;

class RationController extends Controller
{
    public function __construct(public RationService $rationService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rations = QueryBuilder::for(Ration::class)
            ->allowedFilters('name', 'rate', 'code', 'unit', 'producer_name', 'concentration')
            ->allowedSorts('id', 'name')
            ->allowedIncludes('rationRaws.raw.lastRawPrice', 'animalType', 'firstActivity.causer')
            ->paginate(request()->input('per_page', 15));

        return RationResource::collection($rations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRationRequest $request)
    {
        $data = $request->safe()->only([
            'rate',
            'code',
            'name',
            'unit',
            'producer_name',
            'concentration',
        ]);

        $rationRaws = $request->safe()->only([
            'ration_raws',
        ])['ration_raws'];

        $ration = $this->rationService->create($data, $rationRaws);

        return new RationResource($ration->load('rationRaws.raw', 'animalType'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Ration $ration)
    {
        return new RationResource($ration->load('rationRaws.raw.lastRawPrice', 'animalType', 'activities.causer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRationRequest $request, Ration $ration)
    {
        $data = $request->safe()->only([
            'rate',
            'code',
            'name',
            'unit',
            'producer_name',
            'concentration',
        ]);

        $rationRaws = $request->safe()->only([
            'ration_raws',
        ])['ration_raws'];

        $ration = $this->rationService->update($ration, $data, $rationRaws);

        return new RationResource($ration->load('rationRaws.raw', 'animalType'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ration $ration)
    {
        $ration = $this->rationService->delete($ration);

        return $ration->id;
    }

    public function replicate(Ration $ration)
    {
        return new RationResource($this->rationService->replicate($ration)->load('rationRaws.raw.lastRawPrice', 'animalType'));
    }
}
