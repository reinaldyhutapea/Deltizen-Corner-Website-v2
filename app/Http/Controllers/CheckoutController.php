<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    // Tampilkan halaman checkout
    public function showCheckout()
    {
        return view('checkout'); // resources/views/checkout.blade.php
    }

    // Proses pembayaran
    public function prosesPembayaran(Request $request)
{
    $request->validate([
        'order_id' => 'required|integer',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $imageName = time().'.'.$request->image->extension();
    $request->image->move(public_path('bukti'), $imageName);

    $customer = currentCustomer();

    $confirm = new Confirm();
    if ($customer) {
        $confirm->user_id = $customer->id;
        $order = Order::where('id', $request->order_id)->where('user_id', $customer->id)->first();
    } else {
        $visitor_id = session('visitor_id');
        $confirm->visitor_id = $visitor_id;
        $order = Order::where('id', $request->order_id)->where('visitor_id', $visitor_id)->first();
    }

    $confirm->order_id = $request->order_id;
    $confirm->image = $imageName;
    $confirm->status_order = 'menunggu verifikasi';
    $confirm->save();

    if ($order) {
        $order->status = 'menunggu verifikasi';
        $order->save();
    }

    return back()->with('success', 'Bukti pembayaran berhasil dikirim.');
}

}
