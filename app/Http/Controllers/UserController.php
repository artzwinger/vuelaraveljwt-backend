<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Models\UserAttemptLog;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\JWTGuard;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register', 'login']]);
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $user = User::factory()->create([
                'email' => $data['email'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'password' => Hash::make($data['password']),
            ]);
            if ($user->id) {
                return new JsonResponse([
                    'success' => 'User registered'
                ]);
            }
        } catch (UniqueConstraintViolationException) {
            return new JsonResponse([
                'error' => 'User already exists'
            ]);
        }

        return new JsonResponse([
            'error' => 'Something went wrong'
        ]);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $ipAddress = $request->getClientIp();
        $token = $this->getGuard()->attempt($credentials);

        UserAttemptLog::factory()->create([
            'ip_address' => $ipAddress,
            'email' => $credentials['email'],
            'success' => boolval($token)
        ]);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return JWTGuard
     */
    protected function getGuard()
    {
        return auth('api');
    }

    protected function respondWithToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->getGuard()->factory()->getTTL() * 60
        ]);
    }
}
