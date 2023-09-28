<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Receipt\CreateReceiptRequest;
use App\Http\Requests\Api\Receipt\UpdateReceiptRequest;
use App\Http\Resources\Api\ReceiptResource;
use App\Models\Receipt;
use App\Services\ReceiptService;
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
    public function store(CreateReceiptRequest $request, ReceiptService $receiptService)
    {
        $data = $request->safe()->only([
            'rate',
            'code',
            'name',
            'unit',
            'producer_name',
            'concentration',
        ]);

        $receiptRaws = $request->safe()->only([
            'receipt_raws',
        ])['receipt_raws'];

        $receipt = $receiptService->create($data, $receiptRaws);

        return new ReceiptResource($receipt->load('receiptRaws.raw'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Receipt $receipt)
    {
        return new ReceiptResource($receipt->load('receiptRaws.raw.lastRawPrice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReceiptRequest $request, Receipt $receipt, ReceiptService $receiptService)
    {
        $data = $request->safe()->only([
            'rate',
            'code',
            'name',
            'unit',
            'producer_name',
            'concentration',
        ]);

        $receiptRaws = $request->safe()->only([
            'receipt_raws',
        ])['receipt_raws'];

        $receipt = $receiptService->update($receipt, $data, $receiptRaws);

        return new ReceiptResource($receipt->load('receiptRaws.raw'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        $receipt->delete();

        return $receipt->id;
    }
}
