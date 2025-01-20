<?php

namespace App\Presentation\Http\Controllers;

use App\Application\Services\Interfaces\UserServiceInterface;
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

    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return response()->json(
            UserResource::collection($users),
            Response::HTTP_OK
        );
    }

    public function show(string $id): JsonResponse
    {
        $user = $this->userService->getUser($id);
        return response()->json(
            new UserResource($user),
            Response::HTTP_OK
        );
    }

    public function update(UpdateUserRequest $request, string $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());
        return response()->json(
            new UserResource($user),
            Response::HTTP_OK
        );
    }

    public function destroy(string $id): JsonResponse
    {
        $this->userService->deleteUser($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

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

    public function profile(): JsonResponse
    {
        $user = auth()->user();

        return response()->json(
            new UserResource($user),
            Response::HTTP_OK
        );
    }
}
