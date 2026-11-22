<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending   = 'pending';     // menunggu pembayaran
    case Paid      = 'paid';
    case Cancelled = 'cancelled';   // timeout 24 jam / dibatalkan user
}