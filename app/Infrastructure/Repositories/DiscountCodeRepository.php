<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\DiscountCode;
use App\Domain\Repositories\DiscountCodeRepositoryInterface;
use App\Infrastructure\Mappers\DiscountCodeMapper;
use App\Infrastructure\Models\DiscountCode as EloquentDiscountCode;

/**
 * Eloquent implementation of DiscountCodeRepositoryInterface
 */
final class DiscountCodeRepository implements DiscountCodeRepositoryInterface
{
    public function __construct(
        private readonly DiscountCodeMapper $mapper
    )
    {
    }

    /** @inheritDoc */
    public function find(string $id): ?DiscountCode
    {
        $model = EloquentDiscountCode::find($id);
        return $model ? $this->mapper->toDomain($model) : null;
    }

    /** @inheritDoc */
    public function findByCode(string $code): ?DiscountCode
    {
        $model = EloquentDiscountCode::where('code', $code)->first();
        return $model ? $this->mapper->toDomain($model) : null;
    }

    /** @inheritDoc */
    public function findValidByUser(string $userId): array
    {
        return EloquentDiscountCode::where('user_id', $userId)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->get()
            ->map(fn($model) => $this->mapper->toDomain($model))
            ->toArray();
    }

    /** @inheritDoc */
    public function save(DiscountCode $discountCode): void
    {
        $this->mapper->toPersistence($discountCode);
    }

    /** @inheritDoc */
    public function update(DiscountCode $discountCode): void
    {
        $this->mapper->updatePersistence($discountCode);
    }

    /** @inheritDoc */
    public function delete(string $id): void
    {
        EloquentDiscountCode::destroy($id);
    }
}
