<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when trying to create a product with existing SKU
 */
final class DuplicateSkuException extends DomainException
{
    public function __construct(string $sku)
    {
        parent::__construct("Product with SKU already exists: {$sku}");
    }
}
