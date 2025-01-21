<?php


namespace App\Domain\Entities;

use App\Domain\Enums\OrderStatus;
use App\Domain\Exceptions\InsufficientStockException;
use DateTimeImmutable;
use Illuminate\Support\Str;

final class Order
{
    private array $items = [];
    private float $totalAmount = 0.0;
    private ?string $discountCode = null;
    private float $discountAmount = 0.0;
    private ?DateTimeImmutable $discountAppliedAt = null;

    private function __construct(
        private readonly string  $id,
        private readonly string  $userId,
        private OrderStatus      $status,
        private readonly ?string $notes
    )
    {
    }

    public static function create(string $userId, ?string $notes = null): self
    {
        return new self(
            Str::uuid()->toString(),
            $userId,
            OrderStatus::PENDING,
            $notes
        );
    }

    public static function reconstruct(
        string             $id,
        string             $userId,
        OrderStatus        $status,
        ?string            $notes,
        array              $items,
        float              $totalAmount,
        ?string            $discountCode = null,
        float              $discountAmount = 0.0,
        ?DateTimeImmutable $discountAppliedAt = null
    ): self
    {
        $order = new self($id, $userId, $status, $notes);
        $order->items = $items;
        $order->totalAmount = $totalAmount;
        $order->discountCode = $discountCode;
        $order->discountAmount = $discountAmount;
        $order->discountAppliedAt = $discountAppliedAt;

        return $order;
    }

    public function addItem(Product $product, int $quantity): void
    {
        if ($product->getStock() < $quantity) {
            throw new InsufficientStockException(
                $product->getSku(),
                $quantity,
                $product->getStock()
            );
        }

        $item = new OrderItem(
            Str::uuid()->toString(),
            $this->id,
            $product->getId(),
            $quantity,
            $product->getPrice()
        );

        $this->items[] = $item;
        $this->recalculateTotal();

        $product->decreaseStock($quantity);
    }

    public function applyDiscount(DiscountCode $discount, DateTimeImmutable $appliedAt): void
    {
        $this->discountCode = $discount->getCode();
        $this->discountAmount = $discount->calculateAmount($this->getSubtotal());
        $this->discountAppliedAt = $appliedAt;
        $this->recalculateTotal();
    }

    public function getSubtotal(): float
    {
        return array_reduce(
            $this->items,
            fn(float $total, OrderItem $item) => $total + $item->getTotalPrice(),
            0.0
        );
    }

    private function recalculateTotal(): void
    {
        $this->totalAmount = $this->getSubtotal();

        if ($this->discountAmount > 0) {
            $this->totalAmount = max(0, $this->totalAmount - $this->discountAmount);
        }
    }

    public function updateStatus(OrderStatus $newStatus): void
    {
        $this->status = $newStatus;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    public function getTotalAmount(): float
    {
        return $this->totalAmount;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function getDiscountAppliedAt(): ?DateTimeImmutable
    {
        return $this->discountAppliedAt;
    }

    public function getDiscountCode(): ?string
    {
        return $this->discountCode;
    }

    public function getDiscountAmount(): ?float
    {
        return $this->discountAmount;
    }
}
