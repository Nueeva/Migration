<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses Ditolak: Pengguna tidak diautentikasi.'
            ], 401);
        }

        if (!in_array($user->role, $roles)) {
            return response()->json([
                'status'  => 'error',
                'error'   => '403 Forbidden',
                'message' => 'Akses Ditolak: Anda tidak memiliki hak akses (' . implode('/', $roles) . ') untuk menjalankan fitur ini.'
            ], 403);
        }

        return $next($request);
    }
}
