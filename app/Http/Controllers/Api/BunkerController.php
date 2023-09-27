<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BunkerResource;
use App\Models\Bunker;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class BunkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bunkers = QueryBuilder::for(Bunker::class)
            ->allowedFilters('name')
            ->allowedSorts('id', 'name');

        return BunkerResource::collection($bunkers->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $bunker = Bunker::create($data);

        return new BunkerResource($bunker);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bunker $bunker)
    {
        return new BunkerResource($bunker);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bunker $bunker)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $bunker->update($data);

        return new BunkerResource($bunker);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bunker $bunker)
    {
        $bunker->delete();

        return $bunker->id;
    }
}
