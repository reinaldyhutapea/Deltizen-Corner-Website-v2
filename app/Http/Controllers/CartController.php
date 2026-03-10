<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Order;
use App\Models\Order_Product;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    /**
     * Display cart list.
     */
    public function cartList()
    {
        $cartItems = Cart::getContent();

        return view('front.cart', compact('cartItems'));
    }

    /**
     * Add product to cart.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1|max:100',
            'image' => 'nullable|string',
        ]);

        // Verify product exists and is available
        $product = Product::where('id', $request->id)
            ->where('stoks', 1)
            ->first();

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak tersedia.');
        }

        Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => [
                'image' => $request->image,
            ]
        ]);

        session()->flash('success', 'Produk berhasil ditambahkan ke dalam keranjang!');

        return redirect()->route('cart.list');
    }

    /**
     * Update cart item quantity.
     */
    public function updateCart(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        Cart::update($request->id, [
            'quantity' => [
                'relative' => false,
                'value' => $request->quantity
            ],
        ]);

        session()->flash('success', 'Produk berhasil diperbarui!');

        return redirect()->route('cart.list');
    }

    /**
     * Remove item from cart.
     */
    public function removeCart(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        Cart::remove($request->id);
        session()->flash('success', 'Produk berhasil dihapus dari keranjang!');

        return redirect()->route('cart.list');
    }

    /**
     * Clear all items from cart.
     */
    public function clearAllCart()
    {
        Cart::clear();
        session()->flash('success', 'Keranjang berhasil dikosongkan!');

        return redirect()->route('cart.list');
    }

    /**
     * Get cart item count.
     */
    public function cartCount()
    {
        return response()->json([
            'count' => Cart::getTotalQuantity()
        ]);
    }

    /**
     * Display checkout page.
     */
    public function checkout(Request $request)
    {
        if (Cart::getTotalQuantity() < 1) {
            return redirect()->route('cart.list')
                ->with('warning', 'Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        return view('customer.checkout');
    }

    /**
     * Handle guest login for checkout.
     */
    public function guestLogin(Request $request)
    {
        session(['visitor_id' => uniqid('guest_', true)]);

        return redirect()->route('cart.checkout')
            ->with('success', 'Anda melanjutkan sebagai tamu.');
    }

    /**
     * Process payment/order creation.
     */
    public function bayar(CheckoutRequest $request)
    {
        // Check if cart is empty
        if (Cart::getTotalQuantity() < 1) {
            return redirect()->route('cart.list')
                ->with('error', 'Keranjang kosong. Tidak dapat memproses pesanan.');
        }

        $validated = $request->validated();
        $customer = currentCustomer();

        try {
            DB::beginTransaction();

            $order = Order::create([
                'user_id' => $customer ? $customer->id : null,
                'visitor_id' => $customer ? null : session('visitor_id', uniqid('guest_', true)),
                'receiver' => $customer ? $customer->name : $validated['name'],
                'address' => $validated['address'],
                'catatan' => $validated['catatan'] ?? 'Tidak Ada Catatan',
                'detail_status' => Order::$deliveryStatuses[0],
                'status' => Order::STATUS_UNPAID,
                'total_price' => Cart::getTotal(),
                'pickup_time' => $validated['pickup_time'],
                'date' => Carbon::now(),
            ]);

            // Create order products
            foreach (Cart::getContent() as $cart) {
                Order_Product::create([
                    'order_id' => $order->id,
                    'product_id' => $cart->id,
                    'quantity' => $cart->quantity,
                    'subtotal' => $cart->quantity * $cart->price,
                ]);
            }

            DB::commit();

            // Clear cart and session data
            Cart::clear();
            session()->forget(['receiver', 'address', 'catatan', 'pickup_time', 'guest_name', 'guest_address']);

            return redirect()->route('pembayaran', ['id' => $order->id])
                ->with('success', 'Pemesanan berhasil. Silakan lanjut ke pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout failed: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }
    }
}
