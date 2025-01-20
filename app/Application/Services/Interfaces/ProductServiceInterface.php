<?php

namespace App\Application\Services\Interfaces;

use App\Domain\Entities\Product;
use App\Domain\Exceptions\ProductNotFoundException;

/**
 * Service interface for Product operations
 */
interface ProductServiceInterface
{
    /**
     * Get product by ID
     *
     * @param string $id Product ID
     * @return Product|null
     */
    public function getProduct(string $id): ?Product;

    /**
     * Get product by SKU
     *
     * @param string $sku Product SKU
     * @return Product|null
     */
    public function getProductBySku(string $sku): ?Product;

    /**
     * Get all products
     *
     * @return array<Product>
     */
    public function getAllProducts(): array;

    /**
     * Create a new product
     *
     * @param array $data Product data
     * @return Product
     */
    public function createProduct(array $data): Product;

    /**
     * Update product
     *
     * @param string $id Product ID
     * @param array $data Updated product data
     * @return Product
     * @throws ProductNotFoundException
     */
    public function updateProduct(string $id, array $data): Product;

    /**
     * Delete product
     *
     * @param string $id Product ID
     * @return void
     * @throws ProductNotFoundException
     */
    public function deleteProduct(string $id): void;
}
