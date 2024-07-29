<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Api\v1\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication related endpoints"
 * )
 */
class AuthController extends Controller
{
    /** 
     * @OA\Post(
     *     path="/auth/login",
     *     summary="User login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600),
     *             @OA\Property(property="userAbilityRules", type="array", @OA\Items(
     *                @OA\Property(property="ability", type="string", example="create"),
     *                @OA\Property(property="subject", type="string", example="user")
     *            ))
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthenticatedMessage")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="The email field is required. (and 1 more error)"),
     *              @OA\Property(property="errors", type="object", example={"email": {"The email field is required."},
     *                 "password": {"The password field is required."}
     *              }),
     *          ) 
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->unauthorized();
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Get(
     *     path="/auth/me",
     *     summary="Get authenticated user",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user data",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="email_verified_at", type="string", format="date-time", example="2021-01-01T00:00:00.000000Z"),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2021-01-01T00:00:00.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2021-01-01T00:00:00.000000Z") 
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthenticatedMessage")
     *     )
     * )
     */
    public function me()
    {
        return response()->ok(auth()->user());
    }


    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     summary="Log the user out",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthenticatedMessage")
     *     )
     * )
     */
    public function logout()
    {
        auth()->logout(true);

        return response()->ok(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     *     path="/auth/refresh",
     *     summary="Refresh a token",
     *     tags={"Auth"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthenticatedMessage")
     *     )
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh(true, true));
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return Illuminate\Http\JsonResponse;
     */
    protected function respondWithToken($token)
    {
        $userAbilityRules = $this->getUserAbilityRules(auth()->user());

        return response()->ok([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'userAbilityRules' => $userAbilityRules,
        ]);
    }

    /**
     * Get the user ability rules.
     *
     * @param  \App\Models\User $user
     *
     * @return array
     */
    protected function getUserAbilityRules(User $user): array
    {
        $rules = [];

        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $rules[] = [
                    'ability' => $permission->action,
                    'subject' => $permission->subject,
                ];
            }
        }

        return $rules;
    }
}