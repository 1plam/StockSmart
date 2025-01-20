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
    public function toDomain(EloquentProduct $model): Product
    {
        return new Product(
            $model->id,
            $model->name,
            $model->description,
            $model->price,
            $model->stock,
            $model->sku,
            $model->is_active
        );
    }

    /**
     * Convert domain entity to Eloquent model and save
     *
     * @param Product $product Domain entity
     * @return EloquentProduct Created Eloquent model
     */
    public function toPersistence(Product $product): EloquentProduct
    {
        return EloquentProduct::create([
            'name' => $product->getName(),
            'description' => $product->getDescription(),
            'price' => $product->getPrice(),
            'stock' => $product->getStock(),
            'sku' => $product->getSku(),
            'is_active' => $product->isActive()
        ]);
    }

    /**
     * Update existing Eloquent model from domain entity
     *
     * @param Product $product Domain entity
     */
    public function updatePersistence(Product $product): void
    {
        EloquentProduct::where('id', $product->getId())
            ->update([
                'name' => $product->getName(),
                'description' => $product->getDescription(),
                'price' => $product->getPrice(),
                'stock' => $product->getStock(),
                'sku' => $product->getSku(),
                'is_active' => $product->isActive()
            ]);
    }
}
