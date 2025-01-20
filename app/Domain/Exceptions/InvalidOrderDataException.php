<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when order data validation fails
 */
final class InvalidOrderDataException extends DomainException
{
    public function __construct(string $message)
    {
        parent::__construct("Invalid order data: {$message}");
    }
}
