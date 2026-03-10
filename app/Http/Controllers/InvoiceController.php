<?php

namespace App\Http\Controllers;

use App\Models\Order;

class InvoiceController extends Controller
{
    /**
     * Display invoice index page.
     */
    public function index()
    {
        $customer = currentCustomer();
        $visitorId = session('visitor_id');

        $orders = Order::with('products')
            ->where(function ($query) use ($customer, $visitorId) {
                if ($customer) {
                    $query->where('user_id', $customer->id);
                } else {
                    $query->where('visitor_id', $visitorId);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.invoice', compact('orders'));
    }

    /**
     * Display list of invoices for current customer/guest.
     */
    public function list()
    {
        $customer = currentCustomer();
        $visitorId = session('visitor_id');

        $orders = Order::with('products')
            ->where(function ($query) use ($customer, $visitorId) {
                if ($customer) {
                    $query->where('user_id', $customer->id);
                } else {
                    $query->where('visitor_id', $visitorId);
                }
            })
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('customer.list_invoice', compact('orders'));
    }

    /**
     * Display invoice detail.
     */
    public function detail(int $id)
    {
        $customer = currentCustomer();
        $visitorId = session('visitor_id');

        $order = Order::with('products')
            ->where('id', $id)
            ->where(function ($query) use ($customer, $visitorId) {
                if ($customer) {
                    $query->where('user_id', $customer->id);
                } else {
                    $query->where('visitor_id', $visitorId);
                }
            })
            ->firstOrFail();

        return view('customer.invoice_detail', [
            'order' => $order,
            'details' => $order->products,
        ]);
    }
}
