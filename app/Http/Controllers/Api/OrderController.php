<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
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
            ->allowedIncludes('client', 'receipt', 'orderCalculatedRaws.receiptRaw.raw.lastRawPrice')
            ->paginate(request()->input('per_page', 15));

        return OrderResource::collection($receipts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, OrderService $orderService)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'receipt_id' => 'required|exists:receipts,id',
            'batch_quantity' => 'required|numeric|min:1|max:30',
            'batch_inputs' => 'required|array|size:'.$request->input('batch_quantity'),
            'batch_inputs.*' => 'required|numeric',
            'amount' => 'required|numeric|size:'.array_sum($request->input('batch_inputs', [])),
            'error' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $orderService = new OrderService();

        $data['batch_inputs'] = array_map('floatval', $data['batch_inputs']);

        return new OrderResource($orderService->create($data)->load('orderCalculatedRaws.receiptRaw.raw.lastRawPrice'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return new OrderResource($order->load('orderCalculatedRaws.receiptRaw.raw.lastRawPrice', 'receipt', 'client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'receipt_id' => 'required|exists:receipts,id',
            'batch_quantity' => 'required|numeric|min:1|max:30',
            'batch_inputs' => 'required|array|size:'.$request->input('batch_quantity'),
            'batch_inputs.*' => 'required|numeric',
            'amount' => 'required|numeric|size:'.array_sum($request->input('batch_inputs', [])),
            'error' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $orderService = new OrderService();

        $data['batch_inputs'] = array_map('floatval', $data['batch_inputs']);

        $order = $orderService->update($order, $data);

        return new OrderResource($order->load('orderCalculatedRaws.receiptRaw.raw.lastRawPrice'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return $order->id;
    }
}
