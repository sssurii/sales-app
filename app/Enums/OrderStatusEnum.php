<?php

namespace App\Enums;
final class OrderStatusEnum
{
    const PLACED = 'placed';
    const PREPARING = 'preparing';
    const READY = 'ready';
    const DELIVERED = 'delivered';
    const CANCELLED = 'cancelled';
}
