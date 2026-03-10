<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    /**
     * Status constants
     */
    const STATUS_UNPAID = 'belum bayar';
    const STATUS_WAITING = 'menunggu verifikasi';
    const STATUS_PAID = 'dibayar';
    const STATUS_REJECTED = 'ditolak';

    /**
     * Delivery status constants
     */
    public static $deliveryStatuses = [
        'menunggu konfirmasi pembayaran',
        'pesanan sedang disiapkan',
        'pesanan selesai, menunggu konfirmasi penjemputan',
        'selesai'
    ];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'visitor_id',
        'receiver',
        'address',
        'catatan',
        'total_price',
        'date',
        'status',
        'detail_status',
        'pickup_time',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'total_price' => 'decimal:2',
        'date' => 'date',
        'pickup_time' => 'datetime',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the confirm associated with the order.
     */
    public function confirm()
    {
        return $this->hasOne(Confirm::class);
    }

    /**
     * The products that belong to the order.
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product')
                    ->withPivot('quantity', 'subtotal')
                    ->withTimestamps();
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }

    /**
     * Scope a query to filter by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for pending orders.
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_UNPAID);
    }

    /**
     * Scope for completed orders.
     */
    public function scopeCompleted($query)
    {
        return $query->where('detail_status', 'selesai');
    }

    /**
     * Get formatted total price.
     */
    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp. ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Check if order is paid.
     */
    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    /**
     * Check if order is pending.
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_UNPAID;
    }
}