<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Price\CreatePriceRequest;
use App\Http\Requests\Api\Price\UpdatePriceRequest;
use App\Http\Resources\Api\PriceResource;
use App\Models\Price;
use App\Services\PriceService;
use Spatie\QueryBuilder\QueryBuilder;

class PriceController extends Controller
{
    public function __construct(public PriceService $priceService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prices = QueryBuilder::for(Price::class)
            ->allowedFilters('name', 'code')
            ->allowedSorts('id', 'name', 'code')
            ->allowedIncludes('priceRaws.raw', 'firstActivity.causer')
            ->paginate(request()->input('per_page', 15));

        return PriceResource::collection($prices);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePriceRequest $request)
    {
        $data = $request->safe()->only([
            'code',
            'name',
            'unit',
        ]);

        $priceRaws = $request->safe()->only([
            'price_raws',
        ])['price_raws'];

        $price = $this->priceService->create($data, $priceRaws);

        return new PriceResource($price->load('priceRaws.raw'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Price $price)
    {
        return new PriceResource($price->load('priceRaws.raw', 'activities.causer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePriceRequest $request, Price $price)
    {
        $data = $request->safe()->only([
            'code',
            'name',
            'unit',
        ]);

        $priceRaws = $request->safe()->only([
            'price_raws',
        ])['price_raws'];

        $price = $this->priceService->update($price, $data, $priceRaws);

        return new PriceResource($price->load('priceRaws.raw'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Price $price)
    {
        $price = $this->priceService->delete($price);

        return $price->id;
    }

    public function replicate(Price $price)
    {
        $price = $this->priceService->replicate($price);

        return new PriceResource($price->load('priceRaws.raw'));
    }
}
