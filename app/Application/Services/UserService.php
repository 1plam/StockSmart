<?php

namespace App\Application\Services;

use App\Application\Services\Interfaces\UserServiceInterface;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Exceptions\UserNotFoundException;
use Illuminate\Support\Str;

/**
 * Service for managing users
 */
final class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    /** @inheritDoc */
    public function getUser(string $id): ?User
    {
        return $this->userRepository->find($id);
    }

    /** @inheritDoc */
    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }

    /** @inheritDoc */
    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }

    /** @inheritDoc */
    public function createUser(array $data): User
    {
        $user = User::create(
            $data['name'],
            $data['email'],
            $data['password']
        );

        $this->userRepository->save($user);

        return $user;
    }

    /** @inheritDoc */
    public function updateUser(string $id, array $data): User
    {
        $user = $this->getUserOrFail($id);

        $updatedUser = User::reconstruct(
            $user->getId(),
            $data['name'] ?? $user->getName(),
            $data['email'] ?? $user->getEmail(),
            $data['password'] ?? $user->getAuthPassword()
        );

        $this->userRepository->update($updatedUser);

        return $updatedUser;
    }

    /** @inheritDoc */
    public function deleteUser(string $id): void
    {
        $this->getUserOrFail($id);
        $this->userRepository->delete($id);
    }

    /**
     * Get user or throw exception if not found
     * @throws UserNotFoundException
     */
    private function getUserOrFail(string $id): User
    {
        $user = $this->getUser($id);

        if (!$user) {
            throw new UserNotFoundException($id);
        }

        return $user;
    }
}
