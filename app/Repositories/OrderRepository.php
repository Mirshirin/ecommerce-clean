<?php

namespace App\Repositories;

use App\Models\Order;
use App\Contracts\OrderRepositoryInterface;

class OrderRepository implements OrderRepositoryInterface
{
    public function getAllOrders()
    {
        return Order::all();
    }

    public function updateOrderStatus($id, array $status)
    {
        $order = Order::find($id);
        $order->update([
            'delivery_status' => $status['delivery_status'],
            'payment_status' => $status['payment_status']
        ]);
        return $order;
    }
}
