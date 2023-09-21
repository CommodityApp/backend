<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receipts = QueryBuilder::for(Order::class)
            ->allowedFilters('amount', 'error', 'date')
            ->allowedSorts('id', 'amount', 'date')
            ->allowedIncludes('client', 'receipt', 'orderCalculatedRaws.receiptRaw.raw.lastRawPrice', 'animalType')
            ->paginate();

        return OrderResource::collection($receipts);
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
