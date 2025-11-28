<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        $loginAs = $request->input('login_as', 'user');

        // Check if user role matches the selected login type
        if ($loginAs === 'admin' && !$user->isAdmin()) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun ini tidak memiliki akses admin.']);
        }

        if ($loginAs === 'user' && !$user->isUser()) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun ini bukan akun pembeli.']);
        }

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('dashboard');
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
