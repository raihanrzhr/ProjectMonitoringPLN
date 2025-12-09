<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  mixed ...$roles  <-- Menerima banyak role_id
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Cek apakah role user saat ini ada di dalam daftar role yang diizinkan
        // roles parameter dikirim dari route web.php (contoh: 3,4)
        if (in_array($user->role_id, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, bisa redirect ke halaman unauthorized atau 403
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
}