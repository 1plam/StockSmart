<?php

namespace App\Application\Services;

use App\Application\Services\Interfaces\ProductServiceInterface;
use App\Domain\Entities\Product;
use App\Domain\Repositories\ProductRepositoryInterface;
use App\Domain\Exceptions\{ProductNotFoundException, DuplicateSkuException};
use Illuminate\Support\Str;

/**
 * Service for managing products
 */
final class ProductService implements ProductServiceInterface
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    )
    {
    }

    /** @inheritDoc */
    public function getProduct(string $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    /** @inheritDoc */
    public function getProductBySku(string $sku): ?Product
    {
        return $this->productRepository->findBySku($sku);
    }

    /** @inheritDoc */
    public function getAllProducts(): array
    {
        return $this->productRepository->findAll();
    }

    /** @inheritDoc */
    public function createProduct(array $data): Product
    {
        if ($this->getProductBySku($data['sku'])) {
            throw new DuplicateSkuException($data['sku']);
        }

        $product = new Product(
            Str::uuid()->toString(),
            $data['name'],
            $data['description'],
            (float)$data['price'],
            (int)$data['stock'],
            $data['sku'],
            $data['is_active'] ?? true
        );

        $this->productRepository->save($product);

        return $product;
    }

    /** @inheritDoc */
    public function updateProduct(string $id, array $data): Product
    {
        $product = $this->getProductOrFail($id);

        if (isset($data['sku']) && $data['sku'] !== $product->getSku()) {
            if ($this->getProductBySku($data['sku'])) {
                throw new DuplicateSkuException($data['sku']);
            }
        }

        $updatedProduct = new Product(
            $product->getId(),
            $data['name'] ?? $product->getName(),
            $data['description'] ?? $product->getDescription(),
            (float)($data['price'] ?? $product->getPrice()),
            (int)($data['stock'] ?? $product->getStock()),
            $data['sku'] ?? $product->getSku(),
            $data['is_active'] ?? $product->isActive()
        );

        $this->productRepository->update($updatedProduct);

        return $updatedProduct;
    }

    /** @inheritDoc */
    public function deleteProduct(string $id): void
    {
        $this->getProductOrFail($id);
        $this->productRepository->delete($id);
    }

    /**
     * Get product or throw exception if not found
     */
    private function getProductOrFail(string $id): Product
    {
        $product = $this->getProduct($id);

        if (!$product) {
            throw new ProductNotFoundException($id);
        }

        return $product;
    }
}
