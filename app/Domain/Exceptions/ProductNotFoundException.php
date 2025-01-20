<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when a product is not found
 */
final class ProductNotFoundException extends DomainException
{
    public function __construct(string $productId)
    {
        parent::__construct("Product not found: {$productId}");
    }
}
