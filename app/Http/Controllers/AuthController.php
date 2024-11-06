<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ApiResponse;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
     /**
     * @OA\Post(
     *     path="/register",
     *     summary="Register a new user",
     *     tags={"auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="messgae", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request data"
     *     )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            "password_confirmation"=>'required'
        ]);
        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors());
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return ApiResponse::success('User registered successfully!', $user);
    }

    /**
    * @OA\Post(
    *     path="/login",
    *     summary="Log in a user",
    *      tags={"auth"},
    *     @OA\RequestBody(
    *         required=true,
    *         @OA\JsonContent(
    *             required={"email","password"},
    *             @OA\Property(property="email", type="string", format="email", example="john@example.com"),
    *             @OA\Property(property="password", type="string", format="password", example="password")
    *         ),
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="User logged in successfully",
    *         @OA\JsonContent(
    *             @OA\Property(property="success", type="boolean", example=true),
    *             @OA\Property(property="message", type="string", example="User logged in successfully"),
    *             @OA\Property(property="data", type="object",
    *                 @OA\Property(property="access_token", type="string", example="your.jwt.token.here"),
    *                 @OA\Property(property="refresh_token", type="string", example="your.refresh.token.here")
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=401,
    *         description="Unauthorized, invalid credentials"
    *     ),
    *     @OA\Response(
    *         response=400,
    *         description="Invalid request data"
    *     )
    * )
    */
    public function login(Request $request)
    {
       $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users',
        'password' => 'required',
        ]);
        if ($validator->fails()) {
            return ApiResponse::validationError($validator->errors());
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return ApiResponse::success('Login Success', ['access_token' => $token, 'token_type' => 'Bearer']);
    }

    /**
     * @OA\Post(
     *     path="/logout",
     *     summary="Logout the user (Authorization required)",
     *      tags={"auth"},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     ),
     *     security={{"Bearer": {}}}
     * )
     */

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::success('Logged out successfully', null);
    }
    

}
