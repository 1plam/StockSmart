<?php

namespace App\Domain\Entities;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;

final class User implements Authenticatable
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $email,
        private readonly string $password
    )
    {
    }

    // Factory method for creating new users
    public static function create(
        string $name,
        string $email,
        string $password
    ): self
    {
        return new self(
            id: (string)Str::uuid(),
            name: $name,
            email: $email,
            password: $password
        );
    }

    // Factory method for reconstructing from persistence
    public static function reconstruct(
        string $id,
        string $name,
        string $email,
        string $password
    ): self
    {
        return new self($id, $name, $email, $password);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAuthIdentifierName(): string
    {
        return 'id';
    }

    public function getAuthIdentifier(): string
    {
        return $this->id;
    }

    public function getAuthPassword(): string
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
        // Not applicable for domain entity
    }

    public function getRememberTokenName(): string
    {
        return 'remember_token';
    }
}
