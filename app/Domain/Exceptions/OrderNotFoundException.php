<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when an order is not found
 */
final class OrderNotFoundException extends DomainException
{
    public function __construct(string $orderId)
    {
        parent::__construct("Order not found: {$orderId}");
    }
}
