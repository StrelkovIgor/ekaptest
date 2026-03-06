<?php

namespace App\Http\Controllers\Api\v1;

use App\DTO\CreateOrderDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\FilterOrderListRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OrderController extends Controller
{
    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * GET /api/v1/orders
     */
    public function index(FilterOrderListRequest $request)
    {

        $query = Order::query()
            ->with(['items.product', 'customer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('customer_id')) {
            $query->where('customer_id', $request->customer_id);
        }

        if ($from = $request->getCarbonByName('date_from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->getCarbonByName('date_to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $key = md5(http_build_query($request->all()));
        return Cache::tags('order_list')->remember($key, 3600, function() use($query){
            return OrderResource::collection($query->latest()->paginate());
        });
    }

    /**
     * GET /api/v1/orders/{id}
     */
    public function show(Order $order)
    {
        $order->load([
            'items.product',
            'customer'
        ]);

        return new OrderResource($order);
    }

    /**
     * POST /api/v1/orders
     */
    public function store(CreateOrderRequest $request)
    {
        $dto = CreateOrderDTO::fromArray(
            $request->validated()
        );

        $order = $this->orderService->create($dto);
        Cache::tags('order_list')->flush();

        return (new OrderResource($order->load(['items','customer'])))
            ->response()
            ->setStatusCode(201);
    }

    public function updateStatus(UpdateStatusRequest $request, Order $order)
    {
        $order = $this->orderService->updateStatus($order, $request->status);
        return (new OrderResource($order->load(['items','customer'])))
            ->response()
            ->setStatusCode($request->status === 'confirmed' ? 202 : 200);
    }
}
