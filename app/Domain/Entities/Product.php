<?php

namespace App\Domain\Entities;

use App\Domain\Exceptions\InsufficientStockException;

final class Product
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $description,
        private readonly float  $price,
        private int             $stock,
        private readonly string $sku,
        private bool            $isActive = true
    )
    {
    }

    public function decreaseStock(int $quantity): void
    {
        if ($this->stock < $quantity) {
            throw new InsufficientStockException($this->sku, $quantity, $this->stock);
        }
        $this->stock -= $quantity;
    }

    public function increaseStock(int $quantity): void
    {
        $this->stock += $quantity;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}
