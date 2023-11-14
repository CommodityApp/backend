<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProducerResource;
use App\Models\Producer;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $producers = QueryBuilder::for(Producer::class)
            ->allowedFilters('name')
            ->allowedIncludes('country', 'firstActivity.causer')
            ->allowedSorts('id', 'name')
            ->paginate(request()->input('per_page', 15));

        return ProducerResource::collection($producers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
        ]);

        $producer = Producer::create($data);

        return new ProducerResource($producer->load('country'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Producer $producer)
    {
        return new ProducerResource($producer->load('country', 'activities.causer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producer $producer)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'nullable|exists:countries,id',
        ]);

        $producer->update($data);

        return new ProducerResource($producer->load('country'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producer $producer)
    {
        $producer->delete();

        return $producer->id;
    }
}
