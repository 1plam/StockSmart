<?php

namespace App\Application\Services;

use App\Domain\Entities\{DiscountCode, Order};
use App\Domain\Repositories\{DiscountCodeRepositoryInterface, OrderRepositoryInterface};
use App\Domain\Exceptions\DiscountCodeNotFoundException;
use App\Application\Services\Interfaces\DiscountCodeServiceInterface;
use DateTimeImmutable;
use Illuminate\Support\Facades\DB;

/**
 * Service for managing discount codes
 */
final class DiscountCodeService implements DiscountCodeServiceInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly DiscountCodeRepositoryInterface $discountCodeRepository
    ) {
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

        DB::transaction(function () use ($discountCode, $order,) {
            $now = new DateTimeImmutable();

            $discountCode->markAsUsed($now);
            $order->applyDiscount($discountCode, $now);

            $this->discountCodeRepository->update($discountCode);
            $this->orderRepository->update($order);
        });
    }
}
