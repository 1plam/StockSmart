<?php

namespace App\Application\Services\Interfaces;

use App\Domain\Entities\User;
use App\Domain\Exceptions\UserNotFoundException;

/**
 * Service interface for User operations
 */
interface UserServiceInterface
{
    /**
     * Get user by ID
     *
     * @param string $id User identifier
     * @return User|null
     */
    public function getUser(string $id): ?User;

    /**
     * Get user by email
     *
     * @param string $email User email
     * @return User|null
     */
    public function getUserByEmail(string $email): ?User;

    /**
     * Get all users
     *
     * @return array<User>
     */
    public function getAllUsers(): array;

    /**
     * Create a new user
     *
     * @param array $data User data
     * @return User
     */
    public function createUser(array $data): User;

    /**
     * Update user
     *
     * @param string $id User identifier
     * @param array $data Updated user data
     * @return User
     * @throws UserNotFoundException
     */
    public function updateUser(string $id, array $data): User;

    /**
     * Delete user
     *
     * @param string $id User identifier
     * @return void
     * @throws UserNotFoundException
     */
    public function deleteUser(string $id): void;
}
