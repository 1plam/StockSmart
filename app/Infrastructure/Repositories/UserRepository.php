<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Infrastructure\Models\User as EloquentUser;
use App\Infrastructure\Mappers\UserMapper;
use Illuminate\Support\Facades\DB;

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
        return $model ? $this->mapper->fromEloquent($model) : null;
    }

    /** @inheritDoc */
    public function findByEmail(string $email): ?User
    {
        $model = EloquentUser::where('email', $email)->first();
        return $model ? $this->mapper->fromEloquent($model) : null;
    }

    /** @inheritDoc */
    public function findAll(): array
    {
        return EloquentUser::all()
            ->map(fn($model) => $this->mapper->fromEloquent($model))
            ->toArray();
    }

    /** @inheritDoc */
    public function save(User $user): void
    {
        DB::transaction(function () use ($user) {
            EloquentUser::create($this->mapper->toArray($user));
        });
    }

    /** @inheritDoc */
    public function update(User $user): void
    {
        DB::transaction(function () use ($user) {
            EloquentUser::where('id', $user->getId())
                ->update($this->mapper->toArray($user));
        });
    }

    /** @inheritDoc */
    public function delete(string $id): void
    {
        DB::transaction(function () use ($id) {
            EloquentUser::destroy($id);
        });
    }
}
