<?php

namespace App\Http\Controllers;

use App\Models\Confirm;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ConfirmController extends Controller
{
    /**
     * Allowed image extensions for upload.
     */
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    /**
     * Maximum file size in kilobytes.
     */
    private const MAX_FILE_SIZE = 2048; // 2MB

    /**
     * Display payment confirmation form.
     */
    public function index(int $id)
    {
        $customer = currentCustomer();
        $visitorId = session('visitor_id');

        $order = Order::where('id', $id)
            ->where(function ($query) use ($customer, $visitorId) {
                if ($customer) {
                    $query->where('user_id', $customer->id);
                } else {
                    $query->where('visitor_id', $visitorId);
                }
            })
            ->firstOrFail();

        return view('customer.confirm', compact('order'));
    }

    /**
     * Store payment confirmation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:' . self::MAX_FILE_SIZE,
        ], [
            'image.required' => 'Bukti pembayaran wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus: jpg, jpeg, png, gif, atau webp.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $customer = currentCustomer();
        $visitorId = session('visitor_id');

        // Verify order ownership
        $order = Order::where('id', $validated['order_id'])
            ->where(function ($query) use ($customer, $visitorId) {
                if ($customer) {
                    $query->where('user_id', $customer->id);
                } else {
                    $query->where('visitor_id', $visitorId);
                }
            })
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan.');
        }

        try {
            // Secure file upload
            $file = $request->file('image');
            $newName = $this->generateSecureFileName($file);
            
            // Ensure directory exists
            $uploadPath = public_path('upload/confirm');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $file->move($uploadPath, $newName);

            // Create confirmation record
            Confirm::create([
                'order_id' => $order->id,
                'user_id' => $customer?->id,
                'visitor_id' => $customer ? null : $visitorId,
                'image' => 'upload/confirm/' . $newName,
                'status_order' => Order::STATUS_WAITING,
            ]);

            // Update order status
            $order->update(['status' => Order::STATUS_WAITING]);

            return redirect()->route('invoice.list')
                ->with('success', 'Pembayaran berhasil, admin akan verifikasi pesananmu!');

        } catch (\Exception $e) {
            Log::error('Payment confirmation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupload bukti pembayaran.');
        }
    }

    /**
     * Generate secure filename for uploaded file.
     */
    private function generateSecureFileName($file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        return Str::uuid() . '_' . time() . '.' . $extension;
    }
}
