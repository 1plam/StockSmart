<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when a discount code is not found.
 */
final class DiscountCodeNotFoundException extends DomainException
{
    public function __construct()
    {
        parent::__construct("Discount code wasn't found.");
    }
}
