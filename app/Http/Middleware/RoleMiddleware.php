<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles) : Response
    {
        $user = $request->user();

        // 1. Cek apakah pengguna sudah login
        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Ambil nama role secara aman (mencegah eror jika relasi role null)
        $userRole = $user->role->name ?? null;

        // 3. Jika role user tidak sesuai dengan parameter middleware
        if (!$userRole || !in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki hak akses untuk halaman ini.');
        }

        return $next($request);
    }
}