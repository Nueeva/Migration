<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string|min:4',
        ]);

        $user = User::where('email', $request->email)->first();

        // Cek apakah user ada dan password cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email atau Password salah!'
            ], 401);
        }

        // Hapus token lama untuk keamanan (Single-Session Token)
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => 'success',
            'message' => 'Login Berhasil!',
            'user'    => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role ?? 'admin',
            ],
            'token'   => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        // Hapus token aktif saat logout
        if ($request->user() && $request->user()->currentAccessToken()) {
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Logout Berhasil! Akses token telah dicabut.'
        ], 200);
    }

    public function me(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'user'   => $request->user()
        ], 200);
    }
}
