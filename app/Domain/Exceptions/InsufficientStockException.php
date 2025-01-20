<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when attempting to decrease stock below available quantity
 */
final class InsufficientStockException extends DomainException
{
    public function __construct(
        string $sku,
        int    $requested,
        int    $available
    )
    {
        parent::__construct(
            "Insufficient stock for product {$sku}. " .
            "Requested: {$requested}, Available: {$available}"
        );
    }
}
