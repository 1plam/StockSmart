<?php

namespace App\Infrastructure\Mappers;

use App\Domain\Entities\User;
use App\Infrastructure\Models\User as EloquentUser;

/**
 * Mapper for converting between User domain entities and persistence format
 */
final class UserMapper
{
    /**
     * Convert Eloquent model to domain entity
     */
    public function fromEloquent(EloquentUser $model): User
    {
        return User::reconstruct(
            $model->id,
            $model->name,
            $model->email,
            $model->password
        );
    }

    /**
     * Convert domain entity to persistence format
     */
    public function toArray(User $user): array
    {
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getAuthPassword()
        ];
    }
}
