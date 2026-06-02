<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(): View
    {
        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'identity_number' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $key = 'admin-login:'.$request->ip().':'.strtoupper($data['identity_number']);

        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'identity_number' => 'Terlalu banyak percobaan login. Coba lagi beberapa saat.',
            ]);
        }

        if (! Auth::attempt([
            'identity_number' => strtoupper(trim($data['identity_number'])),
            'password' => $data['password'],
            'role' => 'admin',
        ], (bool) $request->boolean('remember'))) {
            RateLimiter::hit($key, 60);

            throw ValidationException::withMessages([
                'identity_number' => 'NIK/NIM atau password admin tidak sesuai.',
            ]);
        }

        RateLimiter::clear($key);
        $request->session()->regenerate();

        $request->user()->update(['last_login_at' => now()]);
        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'Admin login',
            'detail' => 'Admin masuk ke dashboard.',
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
