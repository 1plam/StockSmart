<?php

namespace App\Domain\Entities;

use Illuminate\Support\Str;

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

    public static function create(
        string $name,
        string $description,
        float  $price,
        int    $stock,
        string $sku,
        bool   $isActive = true
    ): self
    {
        return new self(
            Str::uuid()->toString(),
            $name,
            $description,
            $price,
            $stock,
            $sku,
            $isActive
        );
    }

    public static function reconstruct(
        string $id,
        string $name,
        string $description,
        float  $price,
        int    $stock,
        string $sku,
        bool   $isActive = true
    ): self
    {
        return new self($id, $name, $description, $price, $stock, $sku, $isActive);
    }

    // Tracking stock is something for later
    public function decreaseStock(int $quantity): void
    {
        $this->stock -= $quantity;
    }

    public function increaseStock(int $quantity): void
    {
        $this->stock += $quantity;
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
