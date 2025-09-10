<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    public function login(Request $request) {
        try {
            if (!Auth::guard('web')->attempt($request->only('email','password'))) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'data' => null
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

             return response()->json([
                    'message' => 'Login Berhasil!',
                    'data' => [
                        'token' => $token,
                        'user' => new UserResource($user)
                    ]
                ], 200);
        } catch (Exception $e) {
             return response()->json([
                'message' => 'Terjadi Kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function me() {
        try {
            $user = Auth::user();

            return response()->json([
                    'message' => 'Profile User Berhasil Diambil',
                    'data' => new UserResource($user)
                ], 200);
        } catch (Exception $e) {
             return response()->json([
                'message' => 'Terjadi Kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}