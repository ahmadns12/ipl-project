<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\ShippingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'id_buyer', 'id_product', 'total_harga', 'status_pembayaran',
        'nomor_resi', 'status_pengiriman', 'invoice_number', 'jumlah',
        'harga_satuan', 'ongkir', 'kurir', 'alamat_pengiriman',
        'va_number', 'batas_bayar', 'paid_at', 'shipped_at', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'status_pembayaran' => PaymentStatus::class,
            'status_pengiriman' => ShippingStatus::class,
            'total_harga'  => 'decimal:2',
            'harga_satuan' => 'decimal:2',
            'ongkir'       => 'decimal:2',
            'batas_bayar'  => 'datetime',
            'paid_at'      => 'datetime',
            'shipped_at'   => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    // --- Relasi ---
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_buyer');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_product')->withTrashed();
    }

    public function review(): HasOne               // Order 1 - 1 Review
    {
        return $this->hasOne(Review::class, 'id_order');
    }

    // --- State Diagram SDD 3.6 ---
    // pending_payment → paid → shipped → completed  |  cancelled
    public function getStatusAttribute(): string
    {
        if ($this->status_pembayaran === PaymentStatus::Cancelled) return 'cancelled';
        if ($this->status_pembayaran === PaymentStatus::Pending)   return 'pending_payment';

        return match ($this->status_pengiriman) {
            ShippingStatus::Shipped   => 'shipped',
            ShippingStatus::Completed => 'completed',
            default                   => 'paid',   // dibayar, menunggu dikirim Seller
        };
    }

    public function isExpired(): bool
    {
        return $this->status_pembayaran === PaymentStatus::Pending
            && $this->batas_bayar?->isPast();
    }
}