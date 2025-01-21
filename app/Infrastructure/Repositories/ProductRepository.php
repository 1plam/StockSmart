<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Infrastructure\Models\Product as EloquentProduct;
use App\Infrastructure\Mappers\ProductMapper;
use Illuminate\Support\Facades\DB;

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
        return $model ? $this->mapper->fromEloquent($model) : null;
    }

    /** @inheritDoc */
    public function findBySku(string $sku): ?Product
    {
        $model = EloquentProduct::where('sku', $sku)->first();
        return $model ? $this->mapper->fromEloquent($model) : null;
    }

    /** @inheritDoc */
    public function findAll(): array
    {
        return EloquentProduct::all()
            ->map(fn($model) => $this->mapper->fromEloquent($model))
            ->toArray();
    }

    /** @inheritDoc */
    public function save(Product $product): void
    {
        DB::transaction(function () use ($product) {
            EloquentProduct::create($this->mapper->toArray($product));
        });
    }

    /** @inheritDoc */
    public function update(Product $product): void
    {
        DB::transaction(function () use ($product) {
            EloquentProduct::where('id', $product->getId())
                ->update($this->mapper->toArray($product));
        });
    }

    /** @inheritDoc */
    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            EloquentProduct::destroy($id);
        });
    }
}
