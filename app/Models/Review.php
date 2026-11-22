<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = ['id_order', 'id_buyer', 'rating', 'komentar'];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_buyer');
    }
}