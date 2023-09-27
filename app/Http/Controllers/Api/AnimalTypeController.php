<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\AnimalTypeResource;
use App\Models\AnimalType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => ['nullable', Rule::exists('animal_types', 'id')->whereNull('parent_id')],
        ]);

        $animalType = AnimalType::create($data);

        return new AnimalTypeResource($animalType->load('parent'));
    }

    /**
     * Display the specified resource.
     */
    public function show(AnimalType $animalType)
    {
        return new AnimalTypeResource($animalType->load('nestedParent', 'nestedChildren'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnimalType $animalType)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => [
                'nullable',
                Rule::exists('animal_types', 'id')
                    ->whereNull('parent_id')
                    ->whereNot('id', $animalType->id),
            ],
        ]);

        $animalType->update($data);

        return new AnimalTypeResource($animalType->load('parent'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AnimalType $animalType)
    {
        $animalType->delete();

        return $animalType->id;
    }
}
