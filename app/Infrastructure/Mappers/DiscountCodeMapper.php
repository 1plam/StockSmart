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
    public function fromEloquent(EloquentDiscountCode $model): DiscountCode
    {
        return DiscountCode::reconstruct(
            $model->id,
            $model->code,
            $model->amount,
            $model->user_id,
            $model->expires_at ? DateTimeImmutable::createFromInterface($model->expires_at) : null,
            $model->is_used,
            $model->used_at ? DateTimeImmutable::createFromInterface($model->used_at) : null
        );
    }

    /**
     * Convert domain entity to persistence format
     */
    public function toArray(DiscountCode $discountCode): array
    {
        return [
            'id' => $discountCode->getId(),
            'code' => $discountCode->getCode(),
            'amount' => $discountCode->getAmount(),
            'user_id' => $discountCode->getUserId(),
            'expires_at' => $discountCode->getExpiresAt(),
            'is_used' => $discountCode->isUsed(),
            'used_at' => $discountCode->getUsedAt()
        ];
    }
}
