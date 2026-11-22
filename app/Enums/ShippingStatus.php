<?php

namespace App\Enums;

enum ShippingStatus: string
{
    case Waiting   = 'waiting';     // belum dikirim (menunggu bayar / dikemas)
    case Shipped   = 'shipped';
    case Completed = 'completed';   // pesanan diterima buyer
    case Cancelled = 'cancelled';
}