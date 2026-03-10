<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Maximum login attempts before throttling.
     */
    protected int $maxAttempts = 5;

    /**
     * Decay minutes for login throttle.
     */
    protected int $decayMinutes = 1;

    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }

        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login_process(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
        ]);

        // Check rate limiting
        $this->checkTooManyAttempts($request);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Clear rate limiter on successful login
            RateLimiter::clear($this->throttleKey($request));

            return $this->redirectBasedOnRole(Auth::user());
        }

        // Increment failed attempts
        RateLimiter::hit($this->throttleKey($request), $this->decayMinutes * 60);

        return redirect()->route('login')
            ->withInput($request->only('email'))
            ->withErrors(['login_gagal' => 'Email atau Password Anda salah!']);
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout!');
    }

    /**
     * Redirect user based on their role.
     */
    protected function redirectBasedOnRole(User $user)
    {
        return match ($user->role) {
            User::ROLE_ADMIN => redirect()->route('admin.dashboard'),
            User::ROLE_OWNER => redirect()->route('owner.index'),
            User::ROLE_CUSTOMER => redirect()->route('welcome'),
            default => redirect()->route('welcome'),
        };
    }

    /**
     * Check if too many login attempts.
     */
    protected function checkTooManyAttempts(Request $request): void
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey($request), $this->maxAttempts)) {
            $seconds = RateLimiter::availableIn($this->throttleKey($request));

            throw ValidationException::withMessages([
                'email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik.",
            ]);
        }
    }

    /**
     * Get the throttle key for rate limiting.
     */
    protected function throttleKey(Request $request): string
    {
        return strtolower($request->input('email')) . '|' . $request->ip();
    }
}
