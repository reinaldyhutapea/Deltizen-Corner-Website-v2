<?php

namespace App\Http\Controllers;

use App\Models\Confirm;
use App\Models\Order;
use Illuminate\Http\Request;

class ConfirmAdminController extends Controller
{
    /**
     * Display list of pending payment confirmations.
     */
    public function index()
    {
        $confirms = Confirm::with(['user', 'order'])
            ->where('status_order', Order::STATUS_WAITING)
            ->orderBy('id', 'desc')
            ->get();

        return view('confirm.index', [
            'confirms' => $confirms,
            'title' => 'List Konfirmasi Pembayaran Customer',
        ]);
    }

    /**
     * Accept payment confirmation.
     */
    public function terima(int $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => Order::STATUS_PAID]);

        Confirm::where('order_id', $orderId)
            ->update(['status_order' => Order::STATUS_PAID]);

        return redirect()->route('confirmAdmin')
            ->with('status', 'Berhasil dikonfirmasi dengan status DITERIMA');
    }

    /**
     * Reject payment confirmation.
     */
    public function tolak(Request $request, int $orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->status === Order::STATUS_PAID) {
            return redirect()->route('confirmAdmin')
                ->with('error', 'Pesanan sudah dibayar, tidak bisa ditolak!');
        }

        $order->update([
            'status' => Order::STATUS_REJECTED,
            'detail_status' => $request->input('detail_status'),
        ]);

        Confirm::where('order_id', $orderId)
            ->update(['status_order' => Order::STATUS_REJECTED]);

        return redirect()->route('confirmAdmin')
            ->with('status', 'Berhasil dikonfirmasi dengan status DITOLAK');
    }

    /**
     * Display order details.
     */
    public function detail(int $id)
    {
        $order = Order::with('products')->findOrFail($id);
        
        return view('confirm.detail', [
            'details' => $order->products,
            'order' => $order,
        ]);
    }
}
