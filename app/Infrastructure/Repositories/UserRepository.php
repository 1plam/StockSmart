<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Models\User as EloquentUser;
use App\Infrastructure\Mappers\UserMapper;

/**
 * Eloquent implementation of UserRepositoryInterface
 */
final class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly UserMapper $mapper
    )
    {
    }

    /** @inheritDoc */
    public function find(string $id): ?User
    {
        $model = EloquentUser::find($id);
        return $model ? $this->mapper->toDomain($model) : null;
    }

    /** @inheritDoc */
    public function findByEmail(string $email): ?User
    {
        $model = EloquentUser::where('email', $email)->first();
        return $model ? $this->mapper->toDomain($model) : null;
    }

    /** @inheritDoc */
    public function findAll(): array
    {
        return EloquentUser::all()
            ->map(fn($model) => $this->mapper->toDomain($model))
            ->toArray();
    }

    /** @inheritDoc */
    public function save(User $user): void
    {
        $this->mapper->toPersistence($user);
    }

    /** @inheritDoc */
    public function update(User $user): void
    {
        $this->mapper->updatePersistence($user);
    }

    /** @inheritDoc */
    public function delete(string $id): void
    {
        EloquentUser::destroy($id);
    }
}
