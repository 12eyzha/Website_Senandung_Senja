<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Login Employee (API)
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $employee = User::where('email', $credentials['email'])->first();

        if (!$employee || !Hash::check($credentials['password'], $employee->password)) {
            return response()->json([
                'message' => 'Email atau password salah'
            ], 401);
        }

        $token = $employee->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $employee,
        ]);
    }

    /**
     * Logout Employee (API)
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout berhasil'
        ]);
    }
}
