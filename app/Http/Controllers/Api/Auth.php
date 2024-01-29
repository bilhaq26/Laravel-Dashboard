<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth as User;

class Auth extends Controller
{
    public function login(Request $request)
    {
        $key = request()->header('key');
        if ($key == '1234567890') {
            $validate = $request->validate([
                'username' => 'required|string',
                'password' => 'required|string',
            ], [
                'username.required' => 'Username tidak boleh kosong',
                'password.required' => 'Password tidak boleh kosong',
            ]);

            if ($validate) {
                // check jika ada token yang aktif maka logout
                if (User::check()) {
                    User::user()->currentAccessToken()->delete();
                }

                $credentials = request(['username', 'password']);

                if (!User::attempt($credentials)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Username atau password salah',
                    ], 401);
                }

                $user = User::user();

                $token = $user->createToken('authToken')->plainTextToken;

                return response()->json([
                    'status' => 'success',
                    'message' => 'Login berhasil',
                    'data' => [
                        'user' => $user,
                        'token' => $token,
                    ],
                ]);


            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username atau password salah',
                ], 401);
            }
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil',
        ]);
    }
}
