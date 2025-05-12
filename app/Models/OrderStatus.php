<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'status',
    ];

    /**
     * The status options for an order.
     *
     * @var array<string>
     */
    public static $statuses = [
        'pending' => 'Beklemede',
        'approved' => 'Onaylandı',
        'processing' => 'Tedarik Ediliyor',
        'packaging' => 'Kutulanıyor',
        'shipping' => 'Kargoya Verildi',
        'in_transit' => 'Yolda',
        'delivered' => 'Teslim Edildi',
        'completed' => 'Tamamlandı',
        'canceled' => 'İptal Edildi',
    ];

    /**
     * Get the order that owns the status.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the status text.
     *
     * @return string
     */
    public function getStatusTextAttribute()
    {
        return self::$statuses[$this->status] ?? $this->status;
    }
}
