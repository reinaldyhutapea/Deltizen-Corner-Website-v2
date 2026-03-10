<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    /**
     * Display a listing of orders for admin.
     */
    public function index()
    {
        return view('admin.order.index');
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'receiver' => 'required|string|max:255',
            'address' => 'required|string|min:10|max:500',
            'total_price' => 'required|integer|min:0',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            return DB::transaction(function () use ($validated) {
                $product = Product::findOrFail($validated['product_id']);
                
                $order = Order::create([
                    'receiver' => $validated['receiver'],
                    'address' => $validated['address'],
                    'total_price' => $validated['total_price'],
                    'status' => Order::STATUS_UNPAID,
                    'detail_status' => Order::$deliveryStatuses[0],
                    'date' => now(),
                    'user_id' => auth()->id(),
                ]);

                $order->products()->attach($validated['product_id'], [
                    'quantity' => $validated['quantity'],
                    'subtotal' => $validated['quantity'] * $product->price,
                ]);

                return redirect()->route('order.success', ['order' => $order->id])
                    ->with('success', 'Pesanan berhasil dibuat!');
            });
        } catch (\Exception $e) {
            Log::error('Failed to create order: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat pesanan. Silakan coba lagi.');
        }
    }

    /**
     * Get orders data for DataTables.
     */
    public function produkData(Request $request)
    {
        $query = Order::select('id', 'receiver', 'address', 'total_price', 'date', 'status', 'detail_status')
            ->orderBy('id', 'desc');

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->byDateRange($request->from_date, $request->to_date);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('address', fn($row) => $row->address)
            ->addColumn('detail_status', fn($row) => $row->detail_status ?? 'Belum diatur')
            ->addColumn('action', fn($row) => $this->buildActionColumn($row))
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Build the action column HTML for DataTables.
     */
    private function buildActionColumn(Order $row): string
    {
        $statusForm = $this->buildStatusSelectForm($row);
        
        return sprintf(
            '<div class="btn-group">
                <a href="%s" class="btn btn-sm btn-primary">Detail</a>
                <button class="btn btn-sm btn-danger print-btn" data-id="%d">Cetak</button>
                %s
            </div>',
            route('admin.order.detail', $row->id),
            $row->id,
            $statusForm
        );
    }

    /**
     * Build the status select form HTML.
     */
    private function buildStatusSelectForm(Order $row): string
    {
        $options = '<option value="">Pilih Status</option>';
        foreach (Order::$deliveryStatuses as $status) {
            $selected = $row->detail_status === $status ? 'selected' : '';
            $options .= sprintf('<option value="%s" %s>%s</option>', e($status), $selected, e($status));
        }

        return sprintf(
            '<form action="%s" method="POST" style="display:inline;">%s<select name="detail_status" onchange="this.form.submit()">%s</select></form>',
            route('admin.order.updateStatus', $row->id),
            csrf_field(),
            $options
        );
    }

    /**
     * Display invoice detail for customer.
     */
    public function invoiceDetail(int $id)
    {
        $order = Order::with('products')->findOrFail($id);
        
        if ($order->user_id !== auth()->id()) {
            return redirect()->route('invoice.list')
                ->with('warning', 'Anda tidak memiliki akses ke pesanan ini.');
        }
        
        return view('customer.invoice_detail', [
            'order' => $order,
            'details' => $order->products,
        ]);
    }

    /**
     * Display order detail for admin.
     */
    public function detail(int $id)
    {
        $order = Order::with('products')->findOrFail($id);
        
        return view('admin.order.detail', [
            'order' => $order,
            'details' => $order->products,
        ]);
    }

    /**
     * Update order delivery status.
     */
    public function updateStatus(Request $request, int $id)
    {
        $validated = $request->validate([
            'detail_status' => 'required|in:' . implode(',', Order::$deliveryStatuses),
        ]);

        $order = Order::findOrFail($id);
        $order->update(['detail_status' => $validated['detail_status']]);

        return redirect()->route('admin.order.index')
            ->with('success', 'Status pengiriman diperbarui!');
    }
}
