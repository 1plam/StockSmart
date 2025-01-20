<?php

namespace App\Application\Services;

use App\Domain\Entities\DiscountCode;
use App\Domain\Entities\Order;
use App\Domain\Repositories\DiscountCodeRepositoryInterface;
use App\Domain\Exceptions\DiscountCodeNotFoundException;
use App\Application\Services\Interfaces\DiscountCodeServiceInterface;
use App\Domain\Repositories\OrderRepositoryInterface;
use DateTimeImmutable;

/**
 * Service for managing discount codes
 */
final class DiscountCodeService implements DiscountCodeServiceInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface        $orderRepository,
        private readonly DiscountCodeRepositoryInterface $discountCodeRepository
    )
    {
    }

    /** @inheritDoc */
    public function generateForUser(string $userId, float $amount): DiscountCode
    {
        $discountCode = DiscountCode::create($userId, $amount);
        $this->discountCodeRepository->save($discountCode);

        return $discountCode;
    }

    /** @inheritDoc */
    public function applyDiscountToOrder(string $code, Order $order): void
    {
        $discountCode = $this->discountCodeRepository->findByCode($code);
        if (!$discountCode) {
            throw new DiscountCodeNotFoundException($code);
        }

        $now = new DateTimeImmutable();

        $discountCode->markAsUsed($now);
        $order->applyDiscount($discountCode, $now);

        $this->discountCodeRepository->update($discountCode);
        $this->orderRepository->update($order);
    }
}
