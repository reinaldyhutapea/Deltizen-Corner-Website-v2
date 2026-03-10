<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confirm extends Model
{
    use HasFactory;

    protected $table = 'confirms';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'visitor_id',
        'order_id',
        'image',
        'status_order',
    ];

    /**
     * Get the user that owns the confirm.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order that owns the confirm.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
