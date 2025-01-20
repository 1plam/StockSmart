<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when order operation is not allowed in current status
 */
final class InvalidOrderStatusTransitionException extends DomainException
{
    public function __construct(string $currentStatus, string $newStatus)
    {
        parent::__construct(
            "Cannot transition order from {$currentStatus} to {$newStatus}"
        );
    }
}
