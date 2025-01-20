<?php

namespace App\Domain\Exceptions;

/**
 * Base exception class for domain exceptions
 */
abstract class DomainException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
