<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        if (!in_array($user->role, ['admin', 'owner'])) {
            return response()->json([
                'message' => 'Akses ditolak. Hanya admin / owner.'
            ], 403);
        }

        return $next($request);
    }
}
