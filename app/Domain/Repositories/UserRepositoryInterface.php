<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;

/**
 * Interface for managing User persistence
 */
interface UserRepositoryInterface
{
    /**
     * Find user by ID
     *
     * @param string $id User identifier
     * @return User|null
     */
    public function find(string $id): ?User;

    /**
     * Find user by email
     *
     * @param string $email User email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Find all users
     *
     * @return array<User>
     */
    public function findAll(): array;

    /**
     * Save a new user
     *
     * @param User $user
     * @return void
     */
    public function save(User $user): void;

    /**
     * Update an existing user
     *
     * @param User $user
     * @return void
     */
    public function update(User $user): void;

    /**
     * Delete a user
     *
     * @param string $id
     * @return void
     */
    public function delete(string $id): void;
}
