<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\Interfaces\UserServiceInterface;
use App\Domain\Exceptions\UserNotFoundException;
use App\Presentation\Http\Requests\Users\CreateUserRequest;
use App\Presentation\Http\Requests\Users\LoginUserRequest;
use App\Presentation\Http\Requests\Users\UpdateUserRequest;
use App\Presentation\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class UserController extends Controller
{
    public function __construct(
        private readonly UserServiceInterface $userService
    )
    {
    }

    /**
     * Get all users.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return response()->json(
            UserResource::collection($users),
            Response::HTTP_OK
        );
    }

    /**
     * Get a specific user by ID.
     *
     * @param string $id
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->userService->getUser($id);
        return response()->json(
            new UserResource($user),
            Response::HTTP_OK
        );
    }

    /**
     * Update an existing user.
     *
     * @param UpdateUserRequest $request
     * @param string $id
     * @return JsonResponse
     * @throws UserNotFoundException
     */
    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());
        return response()->json(
            new UserResource($user),
            Response::HTTP_OK
        );
    }

    /**
     * Delete a user.
     *
     * @param string $id
     * @return JsonResponse
     * @throws UserNotFoundException
     */
    public function destroy(string $id): JsonResponse
    {
        $this->userService->deleteUser($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Register a new user.
     *
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function register(CreateUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $user = $this->userService->createUser($validatedData);
            Auth::login($user);

            return response()->json([
                'user' => new UserResource($user),
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Login a user.
     *
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            return response()->json([
                'user' => new UserResource($user)
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials'
        ], Response::HTTP_UNAUTHORIZED);
    }
}
