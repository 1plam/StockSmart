<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Infrastructure\Models\Product as EloquentProduct;
use App\Infrastructure\Mappers\ProductMapper;

/**
 * Eloquent implementation of ProductRepositoryInterface
 */
final class ProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private readonly ProductMapper $mapper
    )
    {
    }

    /** @inheritDoc */
    public function find(string $id): ?Product
    {
        $model = EloquentProduct::find($id);
        return $model ? $this->mapper->toDomain($model) : null;
    }

    /** @inheritDoc */
    public function findBySku(string $sku): ?Product
    {
        $model = EloquentProduct::where('sku', $sku)->first();
        return $model ? $this->mapper->toDomain($model) : null;
    }

    /** @inheritDoc */
    public function findAll(): array
    {
        return EloquentProduct::all()
            ->map(fn($model) => $this->mapper->toDomain($model))
            ->toArray();
    }

    /** @inheritDoc */
    public function save(Product $product): void
    {
        $this->mapper->toPersistence($product);
    }

    /** @inheritDoc */
    public function update(Product $product): void
    {
        $this->mapper->updatePersistence($product);
    }

    /** @inheritDoc */
    public function delete(string $id): void
    {
        EloquentProduct::destroy($id);
    }
}
