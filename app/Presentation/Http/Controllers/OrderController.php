<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\Interfaces\OrderServiceInterface;
use App\Presentation\Http\Requests\Orders\CreateOrderRequest;
use App\Presentation\Http\Requests\Orders\UpdateOrderRequest;
use App\Presentation\Http\Requests\Orders\UpdateOrderStatusRequest;
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

    public function index(): JsonResponse
    {
        $orders = $this->orderService->getAllOrders();
        return OrderResource::collection($orders)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function show(string $id): JsonResponse
    {
        $order = $this->orderService->getOrder($id);
        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function store(CreateOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->createOrder($request->validated());
        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(UpdateOrderRequest $request, string $id): JsonResponse
    {
        $order = $this->orderService->updateOrder($id, $request->validated());
        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function updateStatus(UpdateOrderStatusRequest $request, string $id): JsonResponse
    {
        $order = $this->orderService->updateOrderStatus($id, $request->getStatus());
        return (new OrderResource($order))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->orderService->deleteOrder($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
