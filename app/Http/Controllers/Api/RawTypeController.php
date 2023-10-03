<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\RawTypeResource;
use App\Models\RawType;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class RawTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rawTypes = QueryBuilder::for(RawType::class)
            ->allowedFilters('name', 'unit')
            ->allowedSorts('id', 'name', 'unit')
            ->paginate(request()->input('per_page', 15));

        return RawTypeResource::collection($rawTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'present|max:255',
        ]);

        $rawType = RawType::create($data);

        return new RawTypeResource($rawType);
    }

    /**
     * Display the specified resource.
     */
    public function show(RawType $rawType)
    {
        return new RawTypeResource($rawType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RawType $rawType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'present|max:255',
        ]);

        $rawType->update($data);

        return new RawTypeResource($rawType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RawType $rawType)
    {
        $rawType->delete();

        return $rawType->id;
    }
}
