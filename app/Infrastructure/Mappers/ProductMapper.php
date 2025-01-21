<?php

namespace App\Infrastructure\Mappers;

use App\Domain\Entities\Product;
use App\Infrastructure\Models\Product as EloquentProduct;

/**
 * Mapper for converting between Product domain entities and Eloquent models
 */
final class ProductMapper
{
    /**
     * Convert Eloquent model to domain entity
     *
     * @param EloquentProduct $model Eloquent model
     * @return Product Domain entity
     */
    public function fromEloquent(EloquentProduct $model): Product
    {
        return Product::reconstruct(
            $model->id,
            $model->name,
            $model->description,
            (float)$model->price,
            (int)$model->stock,
            $model->sku,
            (bool)$model->is_active
        );
    }

    /**
     * Convert domain entity to persistence format
     */
    public function toArray(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'stock' => $product->getStock(),
            'sku' => $product->getSku(),
            'is_active' => $product->isActive()
        ];
    }
}
