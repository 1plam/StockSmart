<?php

namespace App\Domain\Entities;

use DateTimeImmutable;
use Illuminate\Support\Str;

final class DiscountCode
{
    public function __construct(
        private readonly string            $id,
        private readonly string            $code,
        private readonly float             $amount,
        private readonly string            $userId,
        private readonly DateTimeImmutable $expiresAt,
        private bool                       $isUsed = false,
        private ?DateTimeImmutable         $usedAt = null
    )
    {
    }

    public static function create(
        string             $userId,
        float              $amount,
        ?DateTimeImmutable $expiresAt = null
    ): self
    {
        return new self(
            Str::uuid()->toString(),
            strtoupper(Str::random(8)),
            $amount,
            $userId,
            $expiresAt ?? new DateTimeImmutable('+30 days')
        );
    }

    public function calculateAmount(float $orderAmount): float
    {
        return min($this->amount, $orderAmount);
    }

    public function isValidFor(Order $order): bool
    {
        return $order->getUserId() === $this->userId;
    }

    public function markAsUsed(DateTimeImmutable $currentTime): void
    {
        $this->isUsed = true;
        $this->usedAt = $currentTime;
    }

    private function isExpired(DateTimeImmutable $currentTime): bool
    {
        return $this->expiresAt < $currentTime;
    }

    // Getters
    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getExpiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function isUsed(): bool
    {
        return $this->isUsed;
    }

    public function getUsedAt(): ?DateTimeImmutable
    {
        return $this->usedAt;
    }
}
