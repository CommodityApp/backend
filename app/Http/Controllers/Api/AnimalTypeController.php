<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AnimalTypeResource;
use App\Models\AnimalType;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class AnimalTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $animalTypes = QueryBuilder::for(AnimalType::class)
            ->allowedFilters('name')
            ->allowedSorts('id', 'name');

        if ($request->input('tree', false)) {
            $animalTypes = $animalTypes->root()->with('nestedChildren');
        }

        return AnimalTypeResource::collection($animalTypes->get());
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
