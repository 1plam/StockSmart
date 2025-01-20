<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when a discount code is expired.
 */
final class DiscountCodeExpiredException extends DomainException
{
    public function __construct()
    {
        parent::__construct("Discount code is expired.");
    }
}
