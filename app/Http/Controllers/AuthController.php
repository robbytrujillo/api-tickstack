<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class AuthController extends Controller
{
    public function login(Request $request) {
        try {
            if (!Auth::guard('web')->attemp($request->only('email','password'))) {
                return response()->json([
                    'message' => 'Unautorized',
                    'data' => null
                ], 401);
            }

            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}