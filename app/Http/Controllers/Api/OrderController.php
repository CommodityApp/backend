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
            ->allowedIncludes('client', 'receipt', 'orderCalculatedRaws.receiptRaw.raw.lastRawPrice', 'animalType')
            ->paginate();

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
            'animal_type_id' => 'required|exists:animal_types,id',
            'amount' => 'required|numeric',
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
        return new OrderResource($order->load('orderCalculatedRaws.receiptRaw.raw.lastRawPrice', 'animalType', 'receipt', 'client'));
    }
}
