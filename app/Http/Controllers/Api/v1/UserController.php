<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="User",
 *     description="User related endpoints"
 * )
 */
class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user",
     *     summary="Get list of users",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of users",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="string", format="uuid", example="9ca27831-18f2-427e-a7d1-769ddec840d7"),
     *                 @OA\Property(property="name", type="string", example="Melissa Giuberti L. Schaffer"),
     *                 @OA\Property(property="email", type="string", format="email", example="melissa@liberfly.com"),
     *                 @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example=null),
     *                 @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-29T01:22:31.000000Z"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-29T01:22:31.000000Z")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthenticatedMessage")
     *     )
     * )
     */
    public function index()
    {
        return response()->ok(User::all());
    }

    public function store(Request $request)
    {
        //
    }
   
    /**
     * @OA\Get(
     *     path="/user/{id}",
     *     summary="Get a user by ID",
     *     tags={"User"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", format="uuid"),
     *         description="The ID of the user"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User data",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="string", format="uuid", example="9ca27831-18f2-427e-a7d1-769ddec840d7"),
     *             @OA\Property(property="name", type="string", example="Melissa Giuberti L. Schaffer"),
     *             @OA\Property(property="email", type="string", format="email", example="melissa@liberfly.com"),
     *             @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example=null),
     *             @OA\Property(property="created_at", type="string", format="date-time", example="2024-07-29T01:22:31.000000Z"),
     *             @OA\Property(property="updated_at", type="string", format="date-time", example="2024-07-29T01:22:31.000000Z")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(ref="#/components/schemas/UnauthenticatedMessage")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Not Found")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            return response()->ok(User::findOrFail($id));
        } catch (ModelNotFoundException) {
            return response()->notFound();
        }
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
