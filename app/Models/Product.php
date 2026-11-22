<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'id_seller', 'id_kategori', 'nama_produk',
        'harga', 'stok', 'deskripsi', 'foto',
    ];

    protected function casts(): array
    {
        return ['harga' => 'decimal:2', 'stok' => 'integer'];
    }

    // --- Relasi ---
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_seller');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_kategori');
    }

    public function orders(): HasMany            // Product 1 - N Order
    {
        return $this->hasMany(Order::class, 'id_product');
    }

    public function reviews(): HasManyThrough    // rating produk lewat order
    {
        return $this->hasManyThrough(Review::class, Order::class, 'id_product', 'id_order');
    }

    // --- Accessor & scope ---
    public function getFotoUrlAttribute(): string
    {
        return $this->foto
            ? Storage::disk('public')->url($this->foto)
            : asset('images/no-image.png');
    }

    public function scopeSearch(Builder $q, ?string $keyword): Builder
    {
        return $q->when($keyword, fn ($q) => $q->where('nama_produk', 'like', "%{$keyword}%"));
    }

    public function scopeInCategory(Builder $q, ?string $slug): Builder
    {
        return $q->when($slug, fn ($q) => $q->whereHas('category', fn ($c) => $c->where('slug', $slug)));
    }

    // --- Proteksi stok (atomik, aman dari race condition) ---
    // Mengembalikan true bila stok cukup dan berhasil dipotong.
    public function kurangiStok(int $jumlah): bool
    {
        return static::whereKey($this->id)
            ->where('stok', '>=', $jumlah)
            ->decrement('stok', $jumlah) > 0;
    }
}