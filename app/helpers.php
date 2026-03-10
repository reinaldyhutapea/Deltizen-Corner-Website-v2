<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists('currentCustomer')) {
    /**
     * Get the currently authenticated customer.
     *
     * @return User|null
     */
    function currentCustomer(): ?User
    {
        if (Auth::check() && Auth::user()->role === User::ROLE_CUSTOMER) {
            return Auth::user();
        }

        return null;
    }
}

if (!function_exists('formatRupiah')) {
    /**
     * Format number as Indonesian Rupiah currency.
     *
     * @param  int|float  $amount
     * @return string
     */
    function formatRupiah($amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
