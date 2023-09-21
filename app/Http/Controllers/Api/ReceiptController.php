<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ReceiptResource;
use App\Models\Receipt;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receipts = QueryBuilder::for(Receipt::class)
            ->allowedFilters('name', 'rate', 'code', 'unit', 'producer_name', 'concentration')
            ->allowedSorts('id', 'name')
            ->allowedIncludes('receiptRaws.raw.lastRawPrice')
            ->paginate();

        return ReceiptResource::collection($receipts);
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
