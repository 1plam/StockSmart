<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\Interfaces\OrderItemServiceInterface;
use App\Presentation\Http\Resources\OrderItemResource;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class OrderItemController extends Controller
{
    public function __construct(
        private readonly OrderItemServiceInterface $orderItemService
    )
    {
    }

    /**
     * Get all order items for a specific order.
     *
     * @param string $orderId
     * @return JsonResponse
     */
    public function index(string $orderId): JsonResponse
    {
        $items = $this->orderItemService->getOrderItems($orderId);
        return response()->json(OrderItemResource::collection($items), Response::HTTP_OK);
    }

    /**
     * Get a specific order item by ID.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $item = $this->orderItemService->getOrderItem($id);
        return response()->json(new OrderItemResource($item), Response::HTTP_OK);
    }
}
