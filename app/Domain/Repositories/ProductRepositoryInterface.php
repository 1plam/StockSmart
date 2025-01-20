<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Product;

/**
 * Interface for managing Product persistence
 */
interface ProductRepositoryInterface
{
    /**
     * Find product by ID
     *
     * @param string $id Product identifier
     * @return Product|null Product entity if found, null otherwise
     */
    public function find(string $id): ?Product;

    /**
     * Find product by SKU
     *
     * @param string $sku Product SKU
     * @return Product|null Product entity if found, null otherwise
     */
    public function findBySku(string $sku): ?Product;

    /**
     * Find all products
     *
     * @return Product[] Array of all Product entities
     */
    public function findAll(): array;

    /**
     * Save a new product
     *
     * @param Product $product Product entity to save
     */
    public function save(Product $product): void;

    /**
     * Update an existing product
     *
     * @param Product $product Product entity to update
     */
    public function update(Product $product): void;

    /**
     * Delete a product by ID
     *
     * @param string $id Product identifier
     */
    public function delete(string $id): void;
}
