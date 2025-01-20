<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when product data validation fails
 */
final class InvalidProductDataException extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct("Invalid product data: {$message}");
    }
}
