<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\CreateOrderRequest;
use App\Http\Requests\Api\Order\UpdateOrderRequest;
use App\Http\Resources\Api\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    public function __construct(public OrderService $orderService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $receipts = QueryBuilder::for(Order::class)
            ->allowedFilters('amount', 'error', 'date')
            ->allowedSorts('id', 'amount', 'date')
            ->allowedIncludes('client', 'receipt.animalType', 'orderCalculatedRaws.receiptRaw.raw.lastRawPrice', 'firstActivity.causer')
            ->paginate(request()->input('per_page', 15));

        return OrderResource::collection($receipts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrderRequest $request)
    {
        $data = $request->safe()->all();

        $data['batch_inputs'] = array_map('floatval', $data['batch_inputs']);

        return new OrderResource($this->orderService->create($data)->load('orderCalculatedRaws.receiptRaw.raw.lastRawPrice'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return new OrderResource($order->load('orderCalculatedRaws.receiptRaw.raw.lastRawPrice', 'receipt.animalType', 'client', 'activities.causer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $data = $request->safe();

        $data['batch_inputs'] = array_map('floatval', $data['batch_inputs']);

        $order = $this->orderService->update($order, $data);

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
