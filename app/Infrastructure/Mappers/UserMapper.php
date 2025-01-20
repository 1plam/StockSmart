<?php

namespace App\Infrastructure\Mappers;

use App\Domain\Entities\User;
use App\Infrastructure\Models\User as EloquentUser;

/**
 * Mapper for converting between User domain entities and Eloquent models
 */
final class UserMapper
{
    /**
     * Convert Eloquent model to domain entity
     */
    public function toDomain(EloquentUser $model): User
    {
        return new User(
            $model->id,
            $model->name,
            $model->email,
            $model->password,
        );
    }

    /**
     * Convert domain entity to Eloquent model and save
     */
    public function toPersistence(User $user): EloquentUser
    {
        return EloquentUser::create([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getAuthPassword()
        ]);
    }

    /**
     * Update existing Eloquent model from domain entity
     */
    public function updatePersistence(User $user): void
    {
        EloquentUser::where('id', $user->getId())
            ->update([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => $user->getAuthPassword()
            ]);
    }
}
