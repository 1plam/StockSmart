<?php

namespace App\Domain\Exceptions;

/**
 * Thrown when a user is not found
 */
final class UserNotFoundException extends DomainException
{
    public function __construct(string $userId)
    {
        parent::__construct("User not found: {$userId}");
    }
}
