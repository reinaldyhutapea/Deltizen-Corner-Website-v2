<?php

namespace App\Http\Controllers;

use App\Models\Confirm;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Process admin login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success', 'Login berhasil');
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->withInput();
    }

    /**
     * Logout admin.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')->with('success', 'Logout berhasil');
    }

    /**
     * Display admin dashboard with statistics.
     */
    public function dashboard()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', Order::STATUS_UNPAID)->count(),
            'paid_orders' => Order::where('status', Order::STATUS_PAID)->count(),
            'total_products' => Product::count(),
            'pending_confirmations' => Confirm::where('status_order', Order::STATUS_WAITING)->count(),
        ];

        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    /**
     * Display admin profile.
     */
    public function profil()
    {
        return view('admin.profil');
    }

    /**
     * Update admin password with current password verification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'min:8'],
            'new_confirm_password' => ['required', 'same:new_password'],
        ], [
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_confirm_password.same' => 'Konfirmasi password tidak cocok.',
        ]);

        /** @var User $user */
        $user = auth()->user();
        $user->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('admin.profil')->with('success', 'Password berhasil diubah');
    }
}