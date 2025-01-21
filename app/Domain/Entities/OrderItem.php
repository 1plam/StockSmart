<?php

namespace App\Domain\Entities;

use Illuminate\Support\Str;

final class OrderItem
{
    private float $totalPrice;

    public function __construct(
        private readonly string $id,
        private readonly string $orderId,
        private readonly string $productId,
        private readonly int    $quantity,
        private readonly float  $unitPrice
    )
    {
        $this->totalPrice = $this->unitPrice * $this->quantity;
    }

    public static function create(
        string $orderId,
        string $productId,
        int    $quantity,
        float  $unitPrice
    ): self
    {
        return new self(
            Str::uuid()->toString(),
            $orderId,
            $productId,
            $quantity,
            $unitPrice
        );
    }

    public static function reconstruct(
        string $id,
        string $orderId,
        string $productId,
        int    $quantity,
        float  $unitPrice
    ): self
    {
        return new self($id, $orderId, $productId, $quantity, $unitPrice);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getUnitPrice(): float
    {
        return $this->unitPrice;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }
}
