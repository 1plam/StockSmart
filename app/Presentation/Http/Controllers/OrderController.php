<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\Interfaces\OrderServiceInterface;
use App\Domain\Exceptions\OrderNotFoundException;
use App\Presentation\Http\Requests\Orders\CreateOrderRequest;
use App\Presentation\Http\Resources\OrderResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class OrderController extends Controller
{
    public function __construct(
        private readonly OrderServiceInterface $orderService
    )
    {
    }

    /**
     * Get all orders.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAllOrders();
        return response()->json(OrderResource::collection($orders), Response::HTTP_OK);
    }

    /**
     * Get a specific order by ID.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $order = $this->orderService->getOrder($id);
        return response()->json(new OrderResource($order), Response::HTTP_OK);
    }

    /**
     * Create a new order.
     *
     * @param CreateOrderRequest $request
     * @return JsonResponse
     */
    public function store(CreateOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder($request->validated());
        return response()->json(new OrderResource($order), Response::HTTP_CREATED);
    }

    /**
     * Delete an order.
     *
     * @param string $id
     * @return JsonResponse
     * @throws OrderNotFoundException
     */
    public function destroy(string $id): JsonResponse
    {
        $this->orderService->deleteOrder($id);
        return response()->json(['message' => 'Order has been successfully deleted.'], Response::HTTP_OK);
    }
}
