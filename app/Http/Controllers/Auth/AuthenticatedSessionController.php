<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */

    public function create(): View
    {
        return view('login'); // Pastikan nama file blade Anda sesuai, misal: login.blade.php ada di folder auth
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Ambil data user yang baru login
        $user = $request->user();

        // Cek Role
        // Jika Role 3 (Admin) atau 4 (Pemangku Kepentingan)
        if ($user->role_id == 3 || $user->role_id == 4) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        // Default: Role 1 (Pending) & 2 (User) ke Landing
        return redirect()->intended(route('landing', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
