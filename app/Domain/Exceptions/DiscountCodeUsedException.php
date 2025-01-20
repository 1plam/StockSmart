<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when a discount code is used.
 */
final class DiscountCodeUsedException extends DomainException
{
    public function __construct()
    {
        parent::__construct("Your discount code was already used.");
    }
}
