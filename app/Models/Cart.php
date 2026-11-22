<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = ['id_buyer', 'id_product', 'jumlah'];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_buyer');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'id_product')->withTrashed();
    }

    public function getSubtotalAttribute(): float
    {
        return (float) $this->product->harga * $this->jumlah;
    }
}