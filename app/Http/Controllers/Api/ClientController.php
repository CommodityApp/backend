<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = QueryBuilder::for(Client::class)
            ->allowedFilters('name', 'industry', 'region', 'company')
            ->allowedSorts('id', 'name')
            ->allowedIncludes('country')
            ->paginate();

        return ClientResource::collection($clients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'industry' => 'nullable|string',
            'region' => 'nullable|string',
            'company' => 'nullable|string',
            'country_id' => 'exists:countries,id',
        ]);

        $client = Client::create($data);

        return new ClientResource($client->load('country'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return new ClientResource($client->load('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => 'required',
            'industry' => 'nullable|string',
            'region' => 'nullable|string',
            'company' => 'nullable|string',
            'country_id' => 'exists:countries,id',
        ]);

        $client->update($data);

        return new ClientResource($client->load('country'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return $client->id;
    }
}
