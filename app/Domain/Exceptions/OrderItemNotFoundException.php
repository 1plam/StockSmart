<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when an order item is not found
 */
final class OrderItemNotFoundException extends DomainException
{
    public function __construct(string $itemId)
    {
        parent::__construct("Order item not found: {$itemId}");
    }
}
