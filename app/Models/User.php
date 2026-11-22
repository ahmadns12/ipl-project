<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama', 'email', 'password_hash', 'peran',
        'nomor_telepon', 'alamat', 'is_active', 'saldo',
    ];

    protected $hidden = ['password_hash', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password_hash' => 'hashed',      // otomatis Bcrypt (SRS 4.3)
            'peran'         => Role::class,
            'is_active'     => 'boolean',
            'saldo'         => 'decimal:2',
        ];
    }

    // Beri tahu Laravel Auth bahwa kolom password kita bernama password_hash
    public function getAuthPassword(): string
    {
        return $this->password_hash;
    }

    public function getAuthPasswordName(): string
    {
        return 'password_hash';
    }

    public function isBuyer(): bool  { return $this->peran === Role::Buyer; }
    public function isSeller(): bool { return $this->peran === Role::Seller; }
    public function isAdmin(): bool  { return $this->peran === Role::Admin; }

    // --- Relasi ---
    public function products(): HasMany           // Seller 1 - N Product
    {
        return $this->hasMany(Product::class, 'id_seller');
    }

    public function orders(): HasMany             // Buyer 1 - N Order
    {
        return $this->hasMany(Order::class, 'id_buyer');
    }

    public function sellerOrders(): HasManyThrough // pesanan masuk ke toko Seller
    {
        return $this->hasManyThrough(Order::class, Product::class, 'id_seller', 'id_product');
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class, 'id_buyer');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'id_buyer');
    }
}