<?php

namespace App\Infrastructure\Mappers;

use App\Domain\Entities\DiscountCode;
use App\Infrastructure\Models\DiscountCode as EloquentDiscountCode;
use DateTimeImmutable;

/**
 * Mapper for converting between DiscountCode domain entities and Eloquent models
 */
final class DiscountCodeMapper
{
    /**
     * Convert Eloquent model to domain entity
     */
    public function toDomain(EloquentDiscountCode $model): DiscountCode
    {
        return new DiscountCode(
            id: $model->id,
            code: $model->code,
            amount: $model->amount,
            userId: $model->user_id,
            expiresAt: $model->expires_at ? DateTimeImmutable::createFromInterface($model->expires_at) : null,
            isUsed: $model->is_used,
            usedAt: $model->used_at ? DateTimeImmutable::createFromInterface($model->used_at) : null
        );
    }

    /**
     * Convert domain entity to Eloquent model and save
     */
    public function toPersistence(DiscountCode $discountCode): EloquentDiscountCode
    {
        return EloquentDiscountCode::create([
            'id' => $discountCode->getId(),
            'code' => $discountCode->getCode(),
            'amount' => $discountCode->getAmount(),
            'user_id' => $discountCode->getUserId(),
            'expires_at' => $discountCode->getExpiresAt(),
            'is_used' => $discountCode->isUsed(),
            'used_at' => $discountCode->getUsedAt()
        ]);
    }

    /**
     * Update existing Eloquent model from domain entity
     */
    public function updatePersistence(DiscountCode $discountCode): void
    {
        EloquentDiscountCode::where('id', $discountCode->getId())->update([
            'code' => $discountCode->getCode(),
            'amount' => $discountCode->getAmount(),
            'is_used' => $discountCode->isUsed(),
            'used_at' => $discountCode->getUsedAt()
        ]);
    }
}
