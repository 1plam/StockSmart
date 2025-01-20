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

    public function index(string $orderId): JsonResponse
    {
        $items = $this->orderItemService->getOrderItems($orderId);
        return OrderItemResource::collection($items)
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function show(string $id): JsonResponse
    {
        $item = $this->orderItemService->getOrderItem($id);
        return (new OrderItemResource($item))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
